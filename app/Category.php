<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'category_x_teacher');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Courses', 'category_x_course');
    }
}