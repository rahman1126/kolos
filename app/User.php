<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password','avatar','location','phone', 'home_address', 'home_description','home_latitude','home_longitude','work_address','work_description','work_latitude','work_longitude','other_address','other_description','other_latitude','other_longitude',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'phone_validation',
    ];

    public function merchant()
    {
        return $this->hasOne('App\UserMerchant');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function service()
    {
        return $this->hasMany('App\Service');
    }

    public static function getUser($id)
    {
        return User::find($id);
    }

}
