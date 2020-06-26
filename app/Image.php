<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function document()
    {
        return $this->belongsTo('App\Document');
    }
}
