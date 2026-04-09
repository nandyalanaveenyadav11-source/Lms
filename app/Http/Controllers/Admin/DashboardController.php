<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_trainees' => \App\Models\User::where('role', 'trainee')->count(),
            'total_courses' => \App\Models\Course::count(),
            'total_completions' => \Illuminate\Support\Facades\DB::table('course_user')->where('status', 'completed')->count(),
            'recent_courses' => \App\Models\Course::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
