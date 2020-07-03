<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCourse extends Model
{
    protected $table = 'category_course';

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
