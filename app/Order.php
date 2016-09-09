<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    protected $table = 'orders';

    public function user()
	{
		return $this->belongsTo('App\User');
	}

    public function user_merchant()
	{
		return $this->belongsTo('App\User', 'merchant_id');
	}

    public function merchant()
    {
        return $this->belongsTo('App\UserMerchant', 'merchant_id', 'user_id');
    }

	public function orderservice()
	{
		return $this->hasMany('App\OrderService');
	}

	public function review()
	{
		return $this->hasOne('App\Review');
	}

    public static function getFollowerOrderCount($mId, $uId)
    {
        return Order::where('merchant_id', $mId)->where('user_id', $uId)->count();
    }

    public static function total_order($id)
    {
        return $total = Order::where('merchant_id', $id)->count();
    }

    public static function pending_user_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('user_id', $id)->where('status','0')->count();
        return $value;
    }

    public static function pending_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('merchant_id', $id)->where('status','0')->count();
        return $value;
    }

    public static function inprogress_user_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('user_id', $id)->where('status','1')->count();
        return $value;
    }

    public static function inprogress_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('merchant_id', $id)->where('status','1')->count();
        return $value;
    }

    public static function complete_user_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('user_id', $id)->where('status','2')->count();
        return $value;
    }

    public static function complete_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('merchant_id', $id)->where('status','2')->count();
        return $value;
    }

    public static function canceled_user_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('user_id', $id)->where('status','3')->count();
        return $value;
    }

    public static function canceled_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('merchant_id', $id)->where('status','3')->count();
        return $value;
    }

    public static function declined_user_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('user_id', $id)->where('status','4')->count();
        return $value;
    }

    public static function declined_order($id)
    {
        //$total = Order::where('merchant_id', $id)->count();
        $value = Order::where('merchant_id', $id)->where('status','4')->count();
        return $value;
    }

}
