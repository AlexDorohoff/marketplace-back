<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'user_id', 'name', 'is_persistent'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'pivot'
    ];

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->morphedByMany('App\User', 'taggable');
    }

    public function courses()
    {
        return $this->morphedByMany('App\Course', 'taggable');
    }

    public function documents()
    {
        return $this->morphedByMany('App\Document', 'taggable');
    }
}
