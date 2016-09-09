<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Order;
use App\Review;
use App\Feedback;
use App\UserMerchant;
use App\User;
use App\Alert;

use Auth;
use DB;
use Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex(Request $request)
    {

        if (Auth::user()->status == 2) { // for admin only

            if ($request->has('from') && $request->has('to'))
            {
                $orders = Order::whereBetween('created_at', array($request->input('from'), $request->input('to')))->paginate(20)->setPath('order');
            }
            else
            {

                $query = Order::query();

                if ($request->has('user_id')) {
                    $query->where('user_id', $request->get('user_id'));
                    $results = $query->paginate(20)->setPath('order?user_id='. $request->get('user_id'));
                } elseif ($request->has('merchant_id')) {
                    $query->where('merchant_id', $request->get('merchant_id'));
                    $results = $query->paginate(20)->setPath('order?merchant_id='. $request->get('merchant_id'));
                } else {
                    $query->orderBy('created_at','DESC');
                    $results = $query->paginate(20)->setPath('order');
                }

            }

            return view('admin.order.view')->with('orders', $results);

        } elseif(Auth::user()->status == 1){  // for merchants only

            if ($request->has('status')) {
                if ($request->get('status') == 'current') {

                    $orders = Order::where('merchant_id', '=', Auth::id())
                       ->where(function ($query) {
                           $query->where('status', '=', 0)
                                 ->orWhere('status', '=', 1);
                       })
                       ->orderBy('created_at', 'DESC')
                       ->paginate(20)->setPath('order?status=current');

                } elseif ($request->get('status') == 'past') {
                    $orders = Order::where('merchant_id', '=', Auth::id())
                       ->where(function ($query) {
                           $query->where('status', '=', 2)
                                 ->orWhere('status', '=', 3);
                       })
                       ->orderBy('created_at', 'DESC')
                       ->paginate(20)->setPath('order?status=past');
                } else {
                    $orders = Order::where('merchant_id', Auth::id())
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20)->setPath('order');
                }

            } else {
                $orders = Order::where('merchant_id', Auth::id())
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)->setPath('order');
            }

            return view('admin.order.view')->with('orders', $orders);

        } else { // for everyone

            if ($request->input('status') == 'current') {
                $orders = Order::where('user_id', Auth::id())
                    ->where('status', 0)
                    ->orWhere('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)->setPath('order');
            } elseif ($request->input('status') == 'completed') {
                $orders = Order::where('user_id', Auth::id())
                    ->where('status', 2)
                    ->orWhere('status', 3)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)->setPath('order');
            } else {
                $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at', 'DESC')
                    ->paginate(20)->setPath('order');
            }

            return view('admin.order.view')->with('orders', $orders);
        }
    }

    // get detail of the user who make ann order
    public function getOrderdetail($id)
    {
        if (Auth::user()->status == 2)
        {
            $orders = Order::where('id', $id)->first();
        }
        elseif (Auth::user()->status == 1)
        {
            $orders = Order::where('id', $id)->first();

            if ($orders->merchant_id != Auth::id()) {
                return redirect('home/order')
                    ->with('err','Order does not belongs to you!');
            }
        }


        $review = Review::where('order_id', $id)->first();
        $feedback = Feedback::where('order_id', $id)->first();

        if (!$orders)
        {
            return redirect('home/order')
                ->with('err', 'Sorry, the order you looking for is doesn\'t exists');
        }
        else
        {
            if (Auth::user()->status == 1) {
                return view('admin.order.order_detail_public')
                    ->with('review', $review)
                    ->with('feedback', $feedback)
                    ->with('orders', $orders);
            } else {
                return view('admin.order.user_detail')
                    ->with('review', $review)
                    ->with('feedback', $feedback)
                    ->with('orders', $orders);
            }

        }

    }

    public function getMostorderedmerchants()
    {
        //$merchants = Order::raw('COUNT(DISTINCT *) AS total')->groupBy('user_id')->get();
        $merchants = Order::select(DB::raw('count(*) as order_count, merchant_id'))
            ->groupBy('merchant_id')
            ->orderBy('order_count', 'DESC')
            ->get();
        return view('admin.order.mostorderedmerchants')->with('orders', $merchants);
    }

    public function getCustomerstatistics()
    {
        //$merchants = Order::raw('COUNT(DISTINCT *) AS total')->groupBy('user_id')->get();
        $merchants = Order::select(DB::raw('count(*) as order_count, user_id'))
            ->groupBy('user_id')
            ->orderBy('order_count', 'DESC')
            ->get();
        return view('admin.order.customers')->with('orders', $merchants);
    }

    public function postAccept(Request $request)
    {
        $order = Order::find($request->input('id'));
        $order->status = 1;
        $merchant = UserMerchant::where('user_id', $order->merchant_id)->first();
        if ($order->save()) {

            $message = 'Awesome news!! '. ($merchant->company == '' ? 'The Merchant' : $merchant->company) .' has accepted your request. Please review it in your order menu.';
            $this->push($order->user_id, $message);

            // save alert notification to merchant
            $alert = new Alert;
            $alert->user_id = $order->user_id;
            $alert->order_id = $order->id;
            $alert->message = 'Awesome news!! '. ($merchant->company == '' ? 'The Merchant' : $merchant->company) .' has accepted your request. Please review it in your order menu.';
            $alert->icon = '1';

            if ($alert->save()) {
                $user = User::find($order->user_id);
                Mail::send('emails.acceptedorder', ['user' => $user], function ($m) use ($user) {
                   $m->to($user->email, $user->name)->subject('Your order accepted!');
                });
            }

            return redirect()->back()
                ->with('msg', 'Order has been confirmed');
        } else {
            return redirect()->back()
                ->with('err', 'Order cannot be confirmed');
        }
    }

    public function postDecline(Request $request)
    {
        $order = Order::find($request->input('id'));
        $order->status = 4;
        $merchant = UserMerchant::where('user_id', $order->merchant_id)->first();
        if ($order->save()) {

            $message = 'Sorry, '. ($merchant->company == '' ? 'The Merchant' : $merchant->company) .' is currently unavailable. Please choose an other merchant.';
            $this->push($order->user_id, $message);

            // save alert notification to merchant
            $alert = new Alert;
            $alert->user_id = $order->user_id;
            $alert->order_id = $order->id;
            $alert->message = 'Sorry, '. ($merchant->company == '' ? 'The Merchant' : $merchant->company) .' is currently unavailable. Please choose an other merchant.';
            $alert->icon = '1';

            if ($alert->save()) {
                $user = User::find($order->user_id);
                Mail::send('emails.canceledorder', ['user' => $user], function ($m) use ($user) {
                   $m->to($user->email, $user->name)->subject('Your order declined!');
                });
            }

            return redirect()->back()
                ->with('msg', 'Order has been declined');
        } else {
            return redirect()->back()
                ->with('err', 'Order cannot be declined');
        }
    }

    public function postComplete(Request $request)
    {
        $order = Order::find($request->input('id'));
        $order->status = 2;
        if ($order->save()) {

            $merchant = UserMerchant::find($order->merchant_id);
            $message = 'Your order has been complete.';
            $this->push($order->user_id, $message);

            return redirect()->back()
                ->with('msg', 'Order has been completed');
        } else {
            return redirect()->back()
                ->with('err', 'Order cannot be completed');
        }
    }

    // delete
    public function postDelete(Request $request)
    {
        $id = $request->input('id');
    	$user = Auth::user();

        $order = Order::where('id', $id)->first();

        if (Auth::user()->status != 2) {
            if ($order['merchant_id'] != $user->id) {
                return redirect()->back()
                    ->with('err', 'You don\'t have permission to delete this item');
            }
        }

    	if ($order->delete()) {
    		return redirect()->back()
    		->with('msg', 'Order has been deleted');
    	} else {
    		return redirect()->back()
    		->with('err', 'Order cannot be deleted');
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
