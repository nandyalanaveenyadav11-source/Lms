<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Course::withCount('lessons', 'trainees')->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('domain', 'like', "%{$search}%");
        }
        
        $courses = $query->paginate(12)->withQueryString();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
        ]);

        \App\Models\Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'domain' => $request->domain,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(\App\Models\Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
        ]);

        $course->update($request->only('title', 'description', 'domain'));

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function show(\App\Models\Course $course)
    {
        $course->load('lessons', 'trainees');
        
        $query = \App\Models\User::where('role', 'trainee');
        if ($course->domain) {
            $query->where('domain', $course->domain);
        }
        
        $allTrainees = $query->get();
        return view('admin.courses.show', compact('course', 'allTrainees'));
    }

    public function assign(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $request->validate([
            'trainee_ids' => 'nullable|array',
            'trainee_ids.*' => 'exists:users,id',
            'bulk_type' => 'nullable|string|in:all,domain',
        ]);

        if ($request->bulk_type === 'all') {
            $traineeIds = \App\Models\User::where('role', 'trainee')->pluck('id');
            $course->trainees()->syncWithoutDetaching($traineeIds);
            return back()->with('success', 'Course assigned to ALL trainees successfully.');
        }

        if ($request->bulk_type === 'domain') {
            if (!$course->domain) {
                return back()->with('error', 'Please set a domain for this course first.');
            }
            $traineeIds = \App\Models\User::where('role', 'trainee')->where('domain', $course->domain)->pluck('id');
            $course->trainees()->syncWithoutDetaching($traineeIds);
            return back()->with('success', "Course assigned to all $course->domain trainees successfully.");
        }

        if ($request->trainee_ids) {
            $course->trainees()->syncWithoutDetaching($request->trainee_ids);
        }

        return back()->with('success', 'Course assignment updated successfully.');
    }

    public function importPlaylist(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $request->validate([
            'playlist_url' => 'required|url',
            'api_key' => 'required|string',
        ]);

        // Extract Playlist ID
        parse_str(parse_url($request->playlist_url, PHP_URL_QUERY), $query);
        $playlistId = $query['list'] ?? null;

        if (!$playlistId) {
            return back()->with('error', 'Invalid Playlist URL. Make sure it contains "list=" parameter.');
        }

        $apiKey = $request->api_key;
        $pageToken = '';
        $lessonsCount = 0;

        do {
            $response = \Illuminate\Support\Facades\Http::get("https://www.googleapis.com/youtube/v3/playlistItems", [
                'part' => 'snippet',
                'maxResults' => 50,
                'playlistId' => $playlistId,
                'key' => $apiKey,
                'pageToken' => $pageToken
            ]);

            if ($response->failed()) {
                return back()->with('error', 'YouTube API Error: ' . ($response->json()['error']['message'] ?? 'Unknown error'));
            }

            $data = $response->json();
            $items = $data['items'] ?? [];
            
            if (empty($items)) break;

            // Fetch Durations for all videos in this batch
            $videoIds = collect($items)->pluck('snippet.resourceId.videoId')->implode(',');
            $videoResponse = \Illuminate\Support\Facades\Http::get("https://www.googleapis.com/youtube/v3/videos", [
                'part' => 'contentDetails',
                'id' => $videoIds,
                'key' => $apiKey,
            ]);

            $videoData = $videoResponse->json();
            $durations = collect($videoData['items'] ?? [])->mapWithKeys(function ($item) {
                return [$item['id'] => $this->parseYouTubeDuration($item['contentDetails']['duration'])];
            });

            foreach ($items as $item) {
                $title = $item['snippet']['title'];
                $videoId = $item['snippet']['resourceId']['videoId'];
                $videoUrl = "https://www.youtube.com/watch?v=" . $videoId . "&list=" . $playlistId;
                $durationSeconds = $durations[$videoId] ?? 0;

                $course->lessons()->create([
                    'title' => $title,
                    'video_url' => $videoUrl,
                    'duration_seconds' => $durationSeconds,
                    'order' => $course->lessons()->max('order') + 1,
                ]);
                $lessonsCount++;
            }

            $pageToken = $data['nextPageToken'] ?? '';
        } while ($pageToken);

        return back()->with('success', "Successfully imported $lessonsCount lessons from the playlist.");
    }

    public function syncDurations(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $request->validate(['api_key' => 'required|string']);
        $apiKey = $request->api_key;
        $lessons = $course->lessons;
        $updatedCount = 0;

        // Group into chunks of 50 (YouTube API limit)
        foreach ($lessons->chunk(50) as $chunk) {
            $videoIds = $chunk->map(function($lesson) {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $lesson->video_url, $match)) {
                    return $match[1];
                }
                return null;
            })->filter()->implode(',');

            if (!$videoIds) continue;

            $response = \Illuminate\Support\Facades\Http::get("https://www.googleapis.com/youtube/v3/videos", [
                'part' => 'contentDetails',
                'id' => $videoIds,
                'key' => $apiKey,
            ]);

            if ($response->failed()) continue;

            $videoData = $response->json();
            $durations = collect($videoData['items'] ?? [])->mapWithKeys(function ($item) {
                return [$item['id'] => $this->parseYouTubeDuration($item['contentDetails']['duration'])];
            });

            foreach ($chunk as $lesson) {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $lesson->video_url, $match)) {
                    $videoId = $match[1];
                    if (isset($durations[$videoId])) {
                        $lesson->update(['duration_seconds' => $durations[$videoId]]);
                        $updatedCount++;
                    }
                }
            }
        }

        return back()->with('success', "Instantly synced durations for $updatedCount lessons.");
    }

    private function parseYouTubeDuration($youtube_duration)
    {
        try {
            $duration = new \DateInterval($youtube_duration);
            return ($duration->h * 3600) + ($duration->i * 60) + $duration->s;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function destroy(\App\Models\Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
