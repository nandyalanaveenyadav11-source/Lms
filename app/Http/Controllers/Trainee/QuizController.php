<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $results = \App\Models\Result::where('user_id', auth()->id())
            ->with('quiz.course')
            ->latest()
            ->get();
            
        return view('trainee.quizzes.index', compact('results'));
    }

    public function show(\App\Models\Course $course)
    {
        $quiz = $course->quiz;
        if (!$quiz) abort(404);

        $attempts = \App\Models\Result::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->get();
        $bestResult = $attempts->where('passed', true)->first();
        
        if ($bestResult) {
            return redirect()->route('trainee.quizzes.result', $course)->with('info', 'You have already passed this quiz!');
        }

        if ($attempts->count() >= 5) {
            return redirect()->route('trainee.quizzes.result', $course)->with('error', 'You have reached the maximum of 5 attempts for this quiz.');
        }

        // Check if all lessons are completed
        $totalLessons = $course->lessons()->count();
        $userCompletedInCourse = \Illuminate\Support\Facades\DB::table('lesson_user')
            ->join('lessons', 'lesson_user.lesson_id', '=', 'lessons.id')
            ->where('lesson_user.user_id', auth()->id())
            ->where('lessons.course_id', $course->id)
            ->count();

        if ($userCompletedInCourse < $totalLessons) {
            return redirect()->route('trainee.courses.show', $course)->with('error', 'Please complete all lessons before attempting the quiz.');
        }

        $quiz->load('questions');
        return view('trainee.quizzes.show', compact('course', 'quiz', 'attempts'));
    }

    public function submit(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $quiz = $course->quiz;
        
        $attempts = \App\Models\Result::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->get();
        if ($attempts->where('passed', true)->first()) {
            return redirect()->route('trainee.quizzes.result', $course)->with('error', 'You have already passed this quiz.');
        }

        if ($attempts->count() >= 5) {
            return redirect()->route('trainee.quizzes.result', $course)->with('error', 'Maximum attempts reached.');
        }

        $questions = $quiz->questions;
        $correctCount = 0;
        $total = $questions->count();
        $userAnswers = $request->input('answers', []);

        foreach ($questions as $question) {
            $answer = $request->input('answers.' . $question->id);
            if ($answer === $question->correct_answer) {
                $correctCount++;
            }
        }

        $score = $total > 0 ? round(($correctCount / $total) * 100) : 0;
        $passed = $score >= $quiz->passing_marks;

        $result = \App\Models\Result::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'score' => $score,
            'passed' => $passed,
            'answers' => $userAnswers
        ]);

        if ($passed) {
            // Check if certificate already exists
            if (!\App\Models\Certificate::where('user_id', auth()->id())->where('course_id', $course->id)->exists()) {
                \App\Models\Certificate::create([
                    'user_id' => auth()->id(),
                    'course_id' => $course->id,
                    'score' => $score,
                ]);
            }
        }

        return redirect()->route('trainee.quizzes.result', $course);
    }

    public function result(\App\Models\Course $course)
    {
        $quiz = $course->quiz;
        if (!$quiz) abort(404);

        $result = \App\Models\Result::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->latest()->first();
        if (!$result) {
            return redirect()->route('trainee.quizzes.show', $course)->with('info', 'Please attempt the quiz first.');
        }

        $questions = $quiz->questions;
        $userAnswers = is_string($result->answers) ? json_decode($result->answers, true) : ($result->answers ?? []);
        $attemptsCount = \App\Models\Result::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->count();

        return view('trainee.quizzes.result', compact('course', 'quiz', 'result', 'userAnswers', 'questions', 'attemptsCount'));
    }
}
