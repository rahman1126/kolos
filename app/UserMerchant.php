<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMerchant extends Model
{
    protected $table = 'user_merchant';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function service()
    {
        return $this->hasMany('App\Service');
    }
}
