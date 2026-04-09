<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'domain', 'created_by'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function trainees()
    {
        return $this->belongsToMany(User::class)->withPivot('status')->withTimestamps();
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDurationDisplayAttribute()
    {
        $totalSeconds = $this->lessons()->sum('duration_seconds');
        
        if ($totalSeconds > 0) {
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            
            $display = '';
            if ($hours > 0) $display .= "{$hours}h ";
            if ($minutes > 0 || $hours == 0) $display .= "{$minutes}m";
            
            return trim($display);
        }

        $lessonCount = $this->lessons()->count();
        if ($lessonCount > 0) {
            return $lessonCount . ' ' . ($lessonCount === 1 ? 'Lesson' : 'Lessons');
        }
        
        return "No Content";
    }
}
