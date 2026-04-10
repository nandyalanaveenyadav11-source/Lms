<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Trainee;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('trainee.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('trainees', Admin\TraineeController::class);
    
    Route::resource('courses', Admin\CourseController::class);
    Route::resource('domains', Admin\DomainController::class);
    Route::post('courses/{course}/assign', [Admin\CourseController::class, 'assign'])->name('courses.assign');
    Route::post('courses/{course}/import-playlist', [Admin\CourseController::class, 'importPlaylist'])->name('courses.import-playlist');
    Route::post('courses/{course}/sync-durations', [Admin\CourseController::class, 'syncDurations'])->name('courses.sync-durations');
    Route::resource('courses.lessons', Admin\LessonController::class);
    Route::resource('courses.quizzes', Admin\QuizController::class);
    Route::post('quizzes/{quiz}/questions/import', [Admin\QuestionController::class, 'import'])->name('quizzes.questions.import');
    Route::resource('quizzes.questions', Admin\QuestionController::class);
    
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth', 'role:trainee'])->prefix('trainee')->name('trainee.')->group(function () {
    Route::get('/dashboard', [Trainee\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/courses', [Trainee\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [Trainee\CourseController::class, 'show'])->name('courses.show');
    Route::post('/lessons/{lesson}/complete', [Trainee\CourseController::class, 'completeLesson'])->name('lessons.complete');
    
    Route::get('/quizzes', [Trainee\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/courses/{course}/quiz', [Trainee\QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/courses/{course}/quiz', [Trainee\QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/courses/{course}/quiz/result', [Trainee\QuizController::class, 'result'])->name('quizzes.result');
    
    Route::get('/certificates', [Trainee\CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}/view', [Trainee\CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates/{certificate}/download', [Trainee\CertificateController::class, 'download'])->name('certificates.download');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/fix-storage', function () {
    try {
        Artisan::call('storage:link');
        return "Storage link created successfully! Your PDFs should now be visible.";
    } catch (\Exception $e) {
        return "Error creating link: " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';
