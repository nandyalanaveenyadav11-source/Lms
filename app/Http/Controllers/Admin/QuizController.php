<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function store(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'passing_marks' => 'required|integer|min:0|max:100',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $course->quiz()->create($request->only('title', 'passing_marks', 'duration_minutes'));

        return back()->with('success', 'Quiz created successfully.');
    }

    public function show(\App\Models\Course $course, \App\Models\Quiz $quiz)
    {
        $quiz->load('questions');
        return view('admin.quizzes.show', compact('course', 'quiz'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Course $course, \App\Models\Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'passing_marks' => 'required|integer|min:0|max:100',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz->update($request->only('title', 'passing_marks', 'duration_minutes'));

        return back()->with('success', 'Quiz updated successfully.');
    }

    public function destroy(\App\Models\Course $course, \App\Models\Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.courses.show', $course)->with('success', 'Quiz deleted successfully.');
    }
}
