<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinanceAccount extends Model
{
    protected $fillable = [
        'user_id', 'available_amount', 'reserved_amount',
    ];

    protected $hidden = [
        'id', 'user_id', 'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
