<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses;
        return view('trainee.courses.index', compact('courses'));
    }

    public function show(\App\Models\Course $course)
    {
        if (!auth()->user()->courses->contains($course->id)) {
            abort(403);
        }

        $course->load('lessons', 'quiz');
        $completedLessonIds = auth()->user()->completedLessons()->pluck('lesson_id')->toArray();
        
        $totalLessons = $course->lessons->count();
        $completedCount = $course->lessons->whereIn('id', $completedLessonIds)->count();
        $progress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;

        return view('trainee.courses.show', compact('course', 'completedLessonIds', 'progress'));
    }

    public function completeLesson(\Illuminate\Http\Request $request, \App\Models\Lesson $lesson)
    {
        $user = auth()->user();
        if (!$user->completedLessons->contains($lesson->id)) {
            $user->completedLessons()->attach($lesson->id);
            
            // Check if all lessons are completed to update course status
            $course = $lesson->course;
            $completedCount = $user->completedLessons()->where('course_id', $course->id)->count(); // Wait, this needs careful check
            // Actually, let's just update the specific course_user status if all lessons are done
            $totalLessons = $course->lessons()->count();
            $userCompletedInCourse = \Illuminate\Support\Facades\DB::table('lesson_user')
                ->join('lessons', 'lesson_user.lesson_id', '=', 'lessons.id')
                ->where('lesson_user.user_id', $user->id)
                ->where('lessons.course_id', $course->id)
                ->count();

            if ($userCompletedInCourse >= $totalLessons) {
                $user->courses()->updateExistingPivot($course->id, ['status' => 'completed']);
            }
        }

        return back()->with('success', 'Lesson marked as completed.');
    }
}
