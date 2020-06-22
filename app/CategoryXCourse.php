<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryXCourse extends Model
{
    protected $table = 'category';

    public function course()
    {
        return $this->belongsTo('App\Course', 'id_course');
    }
}
