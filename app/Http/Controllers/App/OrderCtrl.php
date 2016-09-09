<?php

namespace App\Http\Controllers\App;

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

/**
* Order Class
*/
class OrderCtrl extends Controller
{

    /*
    * List of orders for customer users
    * -----------------------------------------
    */
    public function listOrder(Request $request)
    {
    	$id = Auth::user()->id;
    	$user = User::find($id);

        // data past orders
        $orders = Order::where('user_id', '=', Auth::user()->id)
            ->where(function ($query2) {
                $query2->where('status', '=', 2)
                      ->orWhere('status', '=', 3);
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
            'past' => $orders,
            'current' => $orders_current,
        ));
    }


    /**
     * Order Detail
     */
     // order detail
     public function detailOrder(Request $request)
     {
         $id = $request->input('id');
         $order = Order::find($id);
         $review = Review::where('order_id', $id)->get();
         $feedback = Feedback::where('order_id', $id)->get();

         if ($order == null)
         {
             return response()->json(array(
                 'status' => 201,
                 'order' => null,
             ));
         }
         else
         {
             $merchant = UserMerchant::where('user_id', $order->merchant_id)->first();
             $order['merchant'] = $merchant;
             $services = OrderService::select('order_services.*','services.name', 'services.description', 'services.price')
                ->leftJoin('services','services.id','=','order_services.service_id')
                ->where('order_id', $order->id)->get();
             $order['services'] = $services;
             return response()->json([
                 'status' => 200,
                 'order' => $order,
                 'review' => ($review == null ? '' : $review),
                 'feedback' => ($feedback == null ? '' : $feedback),
             ]);
         }
     }


     public function create(Request $request)
     {

     	$user_id = $request->input('id');
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
 //
     	foreach ($services as $service) {

     		if ($order->save()) {
     			$orderService = new OrderService();
 		        $orderService->order_id = $order->id;
 		        $orderService->service_id = $service['service_id'];
                $orderService->quantity = $service['quantity'];
 		        $orderService->save();
     		}
     	}
 //
         // send push notification to merchant
        //  $message = 'Great news!! You get an order. Please review it in your order pro menu.';
        //  $this->push($merchant_id, $message);
         //
        //  // save alert notification to merchant
        //  $alert = new Alert;
        //  $alert->user_id = $merchant_id;
        //  $alert->order_id = $order->id;
        //  $alert->message = 'Great news!! You get an order. Please review it in your order pro menu.';
        //  $alert->icon = '1';
        //  $alert->save();
 //
 //
 //         // send email to merchant
 // //        $user = User::find($request->input('merchant_id'));
 // //        Mail::send('emails.neworder', ['user' => $user], function ($m) use ($user) {
 // //            //$m->from('hello@app.com', 'Your Application');
 // //            $m->to($user->email, $user->name)->subject('You get an order!');
 // //        });
 //
        //  if ($alert->save()) {
        //      // save alert notification to user
        //      $seller = UserMerchant::where('user_id', $request->input('merchant_id'))->first();
        //      $alert = new Alert;
        //      $alert->user_id = $user_id;
        //      $alert->order_id = $order->id;
        //      $alert->message = 'Thank you!! Your order has been made. '. ($seller['company'] == '' ? 'The Merchant' : $seller['company']) .' will get back to you shortly.';
        //      $alert->icon = '2';
        //      $alert->save();
        //  }

     	return response()->json(array(
     		'status' => 200,
            'data' => $request->all(),
     	));
     }


     //  get new order
     public function getNewRecord(Request $request)
     {
         $alert = Alert::where('user_id', $request->input('user_id'))
                         ->where('read', '=', 0)
                         ->count();
         return response()->json($alert);
     }

     public function getLatestRecord(Request $request)
     {
         $order = Order::where('merchant_id', $request->input('user_id'))
                         ->where(function ($query) {
                             $query->where('status', '=', 0)
                                   ->orWhere('status', '=', 1);
                         })
                         ->orderBy('created_at', 'DESC')
                         ->first();

        return response()->json($order);
     }

    //   get last alert
    public function getLatestAlert(Request $request)
    {
        $alert = Alert::where('user_id', $request->input('user_id'))
                        ->where('read', '=', 0)
                        ->orderBy('created_at', 'DESC')
                        ->first();

        return response()->json($alert);
    }

     public function sendEmailNewOrder(Request $request)
     {
         $user = User::find($request->input('user_id'));

         Mail::send('emails.neworder', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('You get an order!');
         });

         return response()->json('Ok');
     }

}


?>
