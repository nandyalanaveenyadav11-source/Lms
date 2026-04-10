<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'type', 'video_url', 'content_path', 'duration_seconds', 'order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getEmbedUrlAttribute()
    {
        $url = $this->video_url;
        $videoId = '';

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoId = $match[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    public function getContentUrlAttribute()
    {
        if ($this->type === 'pdf' && $this->content_path) {
            return asset('storage/' . $this->content_path);
        }
        return null;
    }
}
