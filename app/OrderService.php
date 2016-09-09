<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{

	protected $table = 'order_services';

	public function order()
	{
		return $this->belongsTo('App\Order');
	}

    public function service()
	{
		return $this->belongsTo('App\Service');
	}
}
