<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $completions = \Illuminate\Support\Facades\DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->select('users.name as trainee_name', 'courses.title as course_title', 'course_user.status', 'course_user.updated_at as completion_date')
            ->where('course_user.status', 'completed')
            ->get();

        $quizResults = \App\Models\Result::with('user', 'quiz.course')->latest()->get();

        return view('admin.reports.index', compact('completions', 'quizResults'));
    }
}
