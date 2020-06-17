<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id', 'name', 'content_type', 'description', 'course_id', 'is_public'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
