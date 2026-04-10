<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'domain', 'name');
    }

    public function trainees()
    {
        return $this->hasMany(User::class, 'domain', 'name');
    }
}
