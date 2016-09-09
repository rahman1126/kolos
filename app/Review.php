<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['order_id', 'comment', 'rating'];

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function merchant()
    {
        return $this->belongsTo('App\User', 'merchant_id');
    }

    // total reviews
    public static function reviewnum($id)
    {
        return Review::where('merchant_id', $id)->count();
    }
}
