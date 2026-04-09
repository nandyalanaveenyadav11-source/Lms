<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'video_url', 'duration_seconds', 'order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getEmbedUrlAttribute()
    {
        // Convert YouTube URL to embed format
        // Supports: https://www.youtube.com/watch?v=ID, https://youtu.be/ID, etc.
        $url = $this->video_url;
        $videoId = '';

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoId = $match[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}
