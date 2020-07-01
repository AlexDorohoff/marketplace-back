<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    protected $fillable = [
        'phone', 'email', 'name', 'type', 'image', 'profile'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'profile' => 'array'
    ];

    public function isAdministrativeUser()
    {
        return ($this->type === 'admin' || $this->type === 'manager');
    }

    public function hasOwnership($user_id)
    {
        return $this->id == $user_id || $this->isAdministrativeUser();
    }

    public function toResponse()
    {
        $response = [
            'id' => $this->id,
            'type' => $this->type,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            'image' => $this->image,
            'name' => $this->name
        ];

        if ($this->profile) {
            $response['profile'] = $this->profile;
        }

        return $response;
    }

    public function account()
    {
        return $this->hasOne('App\FinanceAccount');
    }

    public function ownedTags()
    {
        return $this->hasMany('App\Tag');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    public function access()
    {
        return $this->belongsToMany(ImageAccessList::class);
    }
}
