<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherLesson extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
}
