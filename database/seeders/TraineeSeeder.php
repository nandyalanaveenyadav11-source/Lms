<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TraineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Trainee One',
            'email' => 'trainee1@lms.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'trainee',
        ]);

        \App\Models\User::create([
            'name' => 'Trainee Two',
            'email' => 'trainee2@lms.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'trainee',
        ]);
    }
}
