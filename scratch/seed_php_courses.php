<?php
use App\Models\Domain;
use App\Models\User;
use App\Models\Course;

$phpDomain = Domain::firstOrCreate(['name' => 'PHP']);
$admin = User::where('role', 'admin')->first();
$phpTrainees = User::where('role', 'trainee')->where('domain', 'PHP')->pluck('id');

for ($i = 1; $i <= 10; $i++) {
    $course = Course::create([
        'title' => 'Mastering PHP Volume ' . $i,
        'description' => 'Advanced PHP concepts and development practices - Chapter ' . $i,
        'domain' => 'PHP',
        'created_by' => $admin->id
    ]);
    
    if ($phpTrainees->isNotEmpty()) {
        $course->trainees()->syncWithoutDetaching($phpTrainees);
    }
}
echo "Successfully created 10 PHP courses and assigned to " . count($phpTrainees) . " trainees.";
