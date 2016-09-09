<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Alert;
use App\Order;
use App\OrderService;
use App\UserMerchant;
use App\User;


use Auth;

class AlertUccul extends Controller
{
    public function getAlerts(Request $request)
    {
    	// params
    	$id = Auth::user()->id;
    	$alerts = Alert::where('user_id', $id)
            ->orderBy('created_at','DESC')
            ->get();

        if (!$alerts->isEmpty())
        {
            $i = 0;
            foreach ($alerts as $alert)
            {
                $order = Order::find($alert->order_id);
                $user = User::find($alert->user_id);
                $alert['phone'] = $user['phone'];
                $alert['orders'] = $order;

                $merchant = UserMerchant::where('user_id', $order['merchant_id'])->first();

                if($merchant != null)
                {
                  $alert['merchant_name'] = $merchant['company'];
                } else {
                  $alert['merchant_name'] = 'Merchant';
                }


                $alerts[$i]['services'] = OrderService::select('services.id','services.name','services.price','services.description','order_services.quantity')
                    ->leftJoin('services', 'services.id', '=', 'order_services.service_id')
                    ->where('order_services.order_id', $alerts[$i]->order_id)
                    ->orderBy('order_services.created_at', 'DESC')
                    ->get();
                $i++;
            }
        }

    	return response()->json([
    		'status'	=> 200,
    		'alert'		=> $alerts,
    	]);
    }

    public function getAlertNum(Request $request)
    {
        $id = Auth::user()->id;
        $alerts = Alert::where('user_id', $id)->where('read', 0)->count();

        $orders = Order::where('orders.user_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->where('orders.status', '=', 0)
                      ->orWhere('orders.status', '=', 1);
            })
            ->count();

        $orderspro = Order::where('orders.merchant_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->where('orders.status', '=', 0)
                      ->orWhere('orders.status', '=', 1);
            })
            ->count();

        if ($orderspro <= 0)
        {
            $orderspro = 0;
        }

        return response()->json([
            'status' => 200,
            'order_num' => $orders,
            'orderpro_num' => $orderspro,
            'alert_num' => $alerts,
        ]);
    }


    public function postRead(Request $request)
    {
    	$id = $request->input('id'); // alert id
    	$alert = Alert::find($id);
    	$alert->read = 1;
    	$alert->save();

    	return response()->json([
    		'status'	=> 201,
    		'message'	=> 'Alert has been read',
    	]);
    }
}
