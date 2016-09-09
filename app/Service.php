<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = array('name','description','image','price');
    protected $hidden = ['image'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function merchant()
    {
        return $this->belongsTo('App\UserMerchant');
    }

    public function orderservice()
    {
    	return $this->belongsTo('App\orderService');
    }

}
