<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $fillable = [
        'user_id', 'title', 'image', 'price', 'duration', 'annotation', 'description', 'contents', 'is_published'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'description' => 'array',
        'contents' => 'array'
    ];

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');

    }
}
