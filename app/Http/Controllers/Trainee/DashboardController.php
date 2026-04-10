<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [
            'total_assigned_courses' => $user->courses()->count(),
            'completed_courses' => $user->courses()->wherePivot('status', 'completed')->count(),
            'completed_quizzes' => $user->results()->where('passed', true)->count(),
            'total_certificates' => $user->certificates()->count(),
            'assigned_courses' => $user->courses()->get(),
        ];

        return view('trainee.dashboard', $data);
    }
}
