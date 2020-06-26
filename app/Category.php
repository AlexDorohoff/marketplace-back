<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'category_x_course');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class);

    }

    public function parent(){
        return $this->belongsTo('App\Category', 'parent', 'id');
    }

}