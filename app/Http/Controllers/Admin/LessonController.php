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
            'video_url' => 'required|url',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $course->lessons()->create([
            'title' => $request->title,
            'video_url' => $request->video_url,
            'duration_seconds' => $request->duration_minutes ? ($request->duration_minutes * 60) : null,
            'order' => $course->lessons()->max('order') + 1,
        ]);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Course $course, \App\Models\Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $lesson->update([
            'title' => $request->title,
            'video_url' => $request->video_url,
            'duration_seconds' => $request->duration_minutes ? ($request->duration_minutes * 60) : null,
        ]);

        return back()->with('success', 'Lesson updated successfully.');
    }

    public function destroy(\App\Models\Course $course, \App\Models\Lesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }
}
