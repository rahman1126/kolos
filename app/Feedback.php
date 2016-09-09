<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = ['order_id', 'merchant_id', 'comment'];

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    public function merchant()
    {
        return $this->belongsTo('App\User', 'merchant_id');
    }

    public function merchant_detail()
    {
        return $this->belongsTo('App\UserMerchant','merchant_id','user_id');
    }

}
