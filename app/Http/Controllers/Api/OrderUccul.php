<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMerchant;
use App\Service;
use App\Order;
use App\OrderService;
use App\Review;
use App\Feedback;
use App\Alert;

use Auth;
use Mail;
use Validator;

class OrderUccul extends Controller
{
    public function create(Request $request)
    {

    	$user_id = Auth::user()->id;
        $consumer = User::find($user_id);


        // check user active or no
        // if (Auth::user()->active == 0) {
        //     return response()->json([
        //         'status'    => 203,
        //         'error'     => 'Account is not active yet.'
        //     ]);
        // }


        $merchant_id = $request->input('merchant_id');
    	$services = json_decode(stripslashes($request->input('service_id')), true);
        $date = $date=date_create($request->input('booking_time'));

    	$order = new Order;
    	$order->user_id = $user_id;
        $order->merchant_id = $merchant_id;
        $order->booking_time = date_format($date, 'Y-m-d H:i:s');
        $order->location = $request->input('location');
        $order->lon = $request->input('lon');
        $order->lat = $request->input('lat');
        $order->note = $request->input('note');

    	foreach ($services as $service) {

    		if ($order->save()) {
    			$orderService = new OrderService();
		        $orderService->order_id = $order->id;
		        $orderService->service_id = $service['service_id'];
                $orderService->quantity = $service['quantity'];
		        $orderService->save();
    		}
    	}

        // send push notification to merchant
        $message = 'Great news!! You get an order from '. $consumer->name .'. Please review it in your order pro menu.';
        $this->push($merchant_id, $message);

        // save alert notification to merchant
        $alert = new Alert;
        $alert->user_id = $merchant_id;
        $alert->order_id = $order->id;
        $alert->message = 'Great news!! You get an order from '. $consumer->name .'. Please review it in your order pro menu.';
        $alert->icon = '1';
        $alert->save();


        // send email to merchant
    //    $user = User::find($user_id);
    //    Mail::send('emails.neworder', ['user' => $user], function ($m) use ($user) {
    //        //$m->from('hello@app.com', 'Your Application');
    //        $m->to($user->email, $user->name)->subject('You get an order!');
    //    });

        if ($alert->save()) {
            // save alert notification to user
            $seller = UserMerchant::where('user_id', $request->input('merchant_id'))->first();
            $alert = new Alert;
            $alert->user_id = $user_id;
            $alert->order_id = $order->id;
            $alert->message = 'Thank you!! Your order has been made. '. ($seller['company'] == '' ? 'The Merchant' : $seller['company']) .' will get back to you shortly.';
            $alert->icon = '2';
            $alert->save();
        }

    	return response()->json(array(
    		'status' => 200,
    		'data' => 'success',
            'service' => $service,
    	));
    }



    /*
    * List of orders for customer users
    * -----------------------------------------
    */
    public function view(Request $request)
    {
    	$id = Auth::user()->id;
    	$user = User::find($id);

        // data past orders
        $orders = Order::where('user_id', '=', Auth::user()->id)
            ->where(function ($query2) {
                $query2->where('status', '=', 2)
                      ->orWhere('status', '=', 3)
                      ->orWhere('status', '=', 4);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

            $i = 0;
            foreach ($orders as $key) :
                $orders[$i]['services'] = OrderService::select('services.id','services.name','services.price','services.description','order_services.quantity')
                    ->leftJoin('services', 'services.id', '=', 'order_services.service_id')
                    ->where('order_services.order_id', $orders[$i]->id)
                    ->get();
                $orders[$i]['merchant_name'] = UserMerchant::select('company')->where('user_id', $orders[$i]->merchant_id)->first()->company;
                $orders[$i]['merchant_image'] = UserMerchant::select('logo')->where('user_id', $orders[$i]->merchant_id)->first()->logo;
            $i++;
            endforeach;


        // data current orders
        $orders_current = Order::where('user_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->where('status', '=', 0)
                      ->orWhere('status', '=', 1);
            })
            ->orderBy('created_at', 'DESC')
            ->get();


            $i = 0;
            foreach ($orders_current as $key) :
                $orders_current[$i]['services'] = OrderService::select('services.id','services.name','services.price','services.description','order_services.quantity')
                    ->leftJoin('services', 'services.id', '=', 'order_services.service_id')
                    ->where('order_services.order_id', $orders_current[$i]->id)
                    ->get();
                $orders_current[$i]['merchant_name'] = UserMerchant::select('company')->where('user_id', $orders_current[$i]->merchant_id)->first()->company;
                $orders_current[$i]['merchant_image'] = UserMerchant::select('logo')->where('user_id', $orders_current[$i]->merchant_id)->first()->logo;
            $i++;
            endforeach;

        return response()->json(array(
            'status' => 200,
            'error' => false,
            'data_past' => $orders,
            'data_current' => $orders_current,
        ));
    }

    // order view pro
    public function viewpro(Request $request)
    {
        $id = Auth::user()->id;

        if (Auth::user()->status != 1)
        {
            return response()->json([
                'error' => true,
                'message'   => 'Youre not a merchant!',
            ]);
        }

    	$user = User::find($id);

        $orders = Order::select('orders.*')
            ->leftjoin('order_services', 'order_services.order_id', '=', 'orders.id')
            ->where('orders.merchant_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->where('orders.status', '=', 2)
                      ->orWhere('orders.status', '=', 3);
            })
            ->orderBy('orders.created_at', 'DESC')
            ->get();

            $i = 0;
            foreach ($orders as $key) :
                $orders[$i]['services'] = OrderService::select('services.id','services.name','services.price', 'services.description','order_services.quantity')
                    ->leftJoin('services', 'services.id', '=', 'order_services.service_id')
                    ->where('order_services.order_id', $orders[$i]->id)
                    ->get();
                $orders[$i]['merchant_name'] = UserMerchant::select('company')->where('user_id', $orders[$i]->merchant_id)->first()->company;
                $orders[$i]['customer_name'] = User::where('id', $orders[$i]->user_id)->first()->name;

                $orders[$i]['merchant_image'] = UserMerchant::select('logo')->where('user_id', $orders[$i]->merchant_id)->first()->logo;
                $orders[$i]['customer_image'] = User::where('id', $orders[$i]->user_id)->first()->avatar;

                $orders[$i]['user_phone'] = User::select('phone')->where('id', $orders[$i]->user_id)->first()->phone;
            $i++;
            endforeach;

        $orders_current = Order::select('orders.*')
            ->leftjoin('order_services', 'order_services.order_id', '=', 'orders.id')
            ->where('orders.merchant_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->where('orders.status', '=', 0)
                      ->orWhere('orders.status', '=', 1);
            })
            ->orderBy('orders.created_at', 'DESC')
            ->get();

            $i = 0;
            foreach ($orders_current as $key) :
                $orders_current[$i]['services'] = OrderService::select('services.id','services.name','services.price','services.description','order_services.quantity')
                    ->leftJoin('services', 'services.id', '=', 'order_services.service_id')
                    ->where('order_services.order_id', $orders_current[$i]->id)
                    ->get();
                $orders_current[$i]['merchant_name'] = UserMerchant::select('company')->where('user_id', $orders_current[$i]->merchant_id)->first()->company;
                $orders_current[$i]['customer_name'] = User::where('id', $orders_current[$i]->user_id)->first()->name;
                $orders_current[$i]['customer_image'] = User::where('id', $orders_current[$i]->user_id)->first()->avatar;
                $orders_current[$i]['merchant_image'] = UserMerchant::select('logo')->where('user_id', $orders_current[$i]->merchant_id)->first()->logo;
                $orders_current[$i]['user_phone'] = User::select('phone')->where('id', $orders_current[$i]->user_id)->first()->phone;
            $i++;
            endforeach;

        return response()->json(array(
            'status' => 200,
            'data_past' => $orders,
            'data_current' => $orders_current,
        ));

    }

    // get number order
    public function ordernum(Request $request)
    {
        $orders = Order::select('orders.*')
                ->where('orders.user_id', Auth::user()->id)
                ->leftjoin('order_services', 'order_services.order_id', '=', 'orders.id')
                ->where('orders.status', 0)
                ->orWhere('orders.status', 1)
                ->count();

        return response()->json([
            'status' => 200,
            'ordernum' => $orders,
        ]);
    }

    // get number order pro
    public function orderpronum(Request $request)
    {
        $orders = Order::select('orders.*')
                ->where('orders.merchant_id', Auth::user()->id)
                ->leftjoin('order_services', 'order_services.order_id', '=', 'orders.id')
                ->where('orders.status', 0)
                ->orWhere('orders.status', 1)
                ->count();

        return response()->json([
            'status' => 200,
            'ordernum' => $orders,
        ]);
    }

    // order detail
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $order = Order::find($id);
        $review = Review::where('order_id', $id)->get();
        $feedback = Feedback::where('order_id', $id)->get();

        if ($order == null)
        {
            return response()->json(array(
                'status' => 201,
                'order' => '[]',
            ));
        }
        else
        {
            return response()->json([
                'status' => 200,
                'order' => $order,
                'review' => ($review == null ? '' : $review),
                'feedback' => ($feedback == null ? '' : $feedback),
            ]);
        }
    }

    // accept order
    public function accept(Request $request)
    {
        //$id = $request->input('id'); // merchant_id
        $order_id = $request->input('id');
        $order = Order::where('id', $order_id)->first();
        $order->status = 1;
        if ($order->save()) {

            // save alert notification
            $merchant = UserMerchant::find($order->merchant_id);
            $alert = new Alert;
            $alert->user_id = $order->user_id;
            $alert->order_id = $order->id;
            $alert->message = 'Awesome news!! '. ($merchant['company'] == '' ? 'The Merchant' : $merchant['company']) .' has accepted your request. Please review it in your order menu.';
            $alert->icon = '1';
            $alert->save();

            $this->push($order->user_id, $alert->message);

            return response()->json(array(
                'error' => false,
                'status' => 200,
                'data' => 'success',
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'status' => 201,
                'data' => 'fail',
            ));
        }

    }

    // complete order
    public function complete(Request $request)
    {
        $order_id = $request->input('id');
        $order = Order::where('id', $order_id)->first();
        $order->status = 2;
        if ($order->save()) {

            $this->push($order->user_id, 'Your order has been complete.');

            return response()->json(array(
                'error' => false,
                'status' => 200,
                'data' => 'success',
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'status' => 201,
                'data' => 'fail',
            ));
        }
    }

    // decline
    public function decline(Request $request)
    {
        $order_id = $request->input('id');
        $order = Order::where('id', $order_id)->first();
        $order->status = 4;
        if ($order->save()) {

            // save alert notification
            $merchant = UserMerchant::find($order->merchant_id);
            $alert = new Alert;
            $alert->user_id = $order->user_id;
            $alert->order_id = $order->id;
            $alert->message = 'Sorry, '. ($merchant['company'] == '' ? 'The Merchant' : $merchant['company']) .' is currently unavailable. Please choose an other merchant.';
            $alert->icon = '3';
            $alert->save();

            $this->push($order->user_id, $alert->message);

            return response()->json(array(
                'error' => false,
                'status' => 200,
                'data' => 'success',
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'status' => 201,
                'data' => 'fail',
            ));
        }
    }

    // cancel order by customer
    public function cancel(Request $request)
    {
        $order_id = $request->input('id');
        $order = Order::where('id', $order_id)->first();
        $order->status = 3;
        if ($order->save()) {

            // save alert notification
            $user = User::find($order->user_id);
            $alert = new Alert;
            $alert->user_id = $order->merchant_id;
            $alert->order_id = $order->id;
            $alert->message = 'Sorry, '. $user->name .' has canceled his order. Please wait for an other order.';
            $alert->icon = '3';
            $alert->save();

            // send email to merchant
//            $user = User::find($order->user_id);
//            Mail::send('emails.canceledorder', ['user' => $user], function ($m) use ($user) {
//                //$m->from('hello@app.com', 'Your Application');
//                $m->to($user->email, $user->name)->subject('Sorry, '. $user->name .' has canceled his order.');
//            });

            $this->push($order->merchant_id, $alert->message);

            return response()->json(array(
                'error' => false,
                'status' => 200,
                'data' => 'success',
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'status' => 201,
                'data' => 'fail',
            ));
        }
    }


    // push notifications
    public function push($user_id, $message)
    {
        $apiKey = "AIzaSyDbNqntBTSqBJF-TFnVOHUueEiiTUzCO1Q";
        $user = User::find($user_id);
        $registrationIDs = array($user->gcm_id);
        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $fields = array(
                'registration_ids'  => $registrationIDs,
                'data'              => array("message"=>$message),
                );
        $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
                );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($fields) );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        $result = curl_exec($ch);
        if(curl_errno($ch)){ echo 'Curl error: ' . curl_error($ch); }
        curl_close($ch);
        return response()->json($result);
    }
}
