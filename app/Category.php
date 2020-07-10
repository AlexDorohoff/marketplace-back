<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class)->where('type', '==', 'teacher');
    }

    public function parent(){
        return $this->belongsTo('App\Category', 'parent_id', 'id');
    }

    public function children(){
        return $this->hasMany('App\Category', 'parent_id','id');
    }

}