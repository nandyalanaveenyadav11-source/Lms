<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function store(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf',
            'video_url' => 'required_if:type,video|nullable|url',
            'pdf_file' => 'required_if:type,pdf|nullable|file|mimes:pdf|max:10000',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $contentPath = null;
        if ($request->hasFile('pdf_file')) {
            $contentPath = $request->file('pdf_file')->store('lessons/pdfs', 'public');
        }

        $course->lessons()->create([
            'title' => $request->title,
            'type' => $request->type,
            'video_url' => $request->video_url,
            'content_path' => $contentPath,
            'duration_seconds' => $request->duration_minutes ? ($request->duration_minutes * 60) : null,
            'order' => $course->lessons()->max('order') + 1,
        ]);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Course $course, \App\Models\Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf',
            'video_url' => 'required_if:type,video|nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10000',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'video_url' => $request->video_url,
            'duration_seconds' => $request->duration_minutes ? ($request->duration_minutes * 60) : null,
        ];

        if ($request->hasFile('pdf_file')) {
            // Delete old file if exists
            if ($lesson->content_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lesson->content_path);
            }
            $data['content_path'] = $request->file('pdf_file')->store('lessons/pdfs', 'public');
        }

        $lesson->update($data);

        return back()->with('success', 'Lesson updated successfully.');
    }

    public function destroy(\App\Models\Course $course, \App\Models\Lesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }
}
