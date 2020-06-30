<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'path',
        'is_public',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'is_public'
    ];

    public function document()
    {
        return $this->belongsTo('App\Document');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
