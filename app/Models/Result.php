<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['quiz_id', 'user_id', 'score', 'passed', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
