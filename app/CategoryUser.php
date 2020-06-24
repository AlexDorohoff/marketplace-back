<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{
    protected $table = 'category_user';

    public function teacher()
    {
        return $this->belongsTo('App\User', 'id_teacher');
    }

    public function courses()
    {
        return $this->belongsTo('App\Category', 'id_category');
    }
}
