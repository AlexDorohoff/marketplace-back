<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseStatus extends Model
{

    public function toResponse()
    {
        $response = [
            'id' => $this->id,
            'label' => $this->label,
        ];

        return $response;
    }

    public function requests()
    {
        return $this->hasMany('App\Request');
    }


}
