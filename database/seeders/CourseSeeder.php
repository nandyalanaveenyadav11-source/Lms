<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        $trainees = \App\Models\User::where('role', 'trainee')->get();

        if (!$admin) return;

        $course = \App\Models\Course::create([
            'title' => 'Laravel for Beginners',
            'description' => 'Learn the basics of Laravel framework from scratch.',
            'created_by' => $admin->id,
        ]);

        $lessons = [
            ['title' => 'Introduction to Laravel', 'video_url' => 'https://www.youtube.com/watch?v=MYyJ4PuL4pY', 'order' => 1],
            ['title' => 'Installation and Setup', 'video_url' => 'https://www.youtube.com/watch?v=f-B5XGfL1U4', 'order' => 2],
            ['title' => 'Routing and Controllers', 'video_url' => 'https://www.youtube.com/watch?v=8p_AnWw5aM0', 'order' => 3],
        ];

        foreach ($lessons as $lesson) {
            $course->lessons()->create($lesson);
        }

        $quiz = $course->quiz()->create([
            'title' => 'Laravel Basics Quiz',
            'passing_marks' => 70,
        ]);

        $quiz->questions()->create([
            'question_text' => 'What is Laravel?',
            'option_a' => 'A Javascript Library',
            'option_b' => 'A PHP framework',
            'option_c' => 'A Database',
            'option_d' => 'An Operating System',
            'correct_answer' => 'b',
        ]);

        $quiz->questions()->create([
            'question_text' => 'Which command is used to create a controller in Laravel?',
            'option_a' => 'php artisan make:controller',
            'option_b' => 'php artisan create:controller',
            'option_c' => 'laravel make:controller',
            'option_d' => 'composer make:controller',
            'correct_answer' => 'a',
        ]);

        // Assign to trainees
        foreach ($trainees as $trainee) {
            $trainee->courses()->attach($course->id);
        }
    }
}
