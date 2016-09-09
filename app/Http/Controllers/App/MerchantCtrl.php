<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use App\Service;
use App\Favorite;
use App\UserMerchant;
use App\Review;
use App\ProRequest;
use App\Order;

use Auth;
use Validator;

/**
 * Merchant Ctrl
 */
class MerchantCtrl extends Controller
{

    // merchant detail
    public function detailMerchant(Request $request)
    {
    	$id = $request->input('id');
        $merchant = UserMerchant::where('active', 1)
            ->where('user_id', $id)->first();
        $services = Service::where('user_id', $id)->get();
        $reviews = Review::select('reviews.*','users.avatar','users.name','feedbacks.comment as merchant_feedback')
            ->where('reviews.merchant_id', $id)
            ->leftJoin('feedbacks','feedbacks.order_id','=','reviews.order_id')
            ->leftJoin('users','users.id','=','reviews.customer_id')
            ->orderBy('created_at','DESC')
            ->limit(5)
            ->get();
        //$number_votes = Review::where('merchant_id', $id)->get()->count();
        //$user = User::find($request->input('id'));
        $total_order = Order::where('merchant_id', $id)->count();

        if (!$merchant)
        {
            return response()->json([
                'status' => 401,
                'error' => 'He is not a merchant',
            ]);
        }

        if ($request->input('user_id') != null)
        {


            $favorited = Favorite::where('user_id', $request->input('user_id'))
                ->where('merchant_id', $id)->first();

            if ($favorited) {
                $isFav = true;
            } else {
                $isFav = false;
            }

            if (!$merchant) {
                return response()->json(array(
                    'status' => 201,
                    'merchant' => 'No merchant found.',
                ));
            } else {
                return response()->json(array(
                    'status' => 200,
                    'favorite' => $isFav,
                    'merchant' => $merchant,
                    'services' => $services,
                    'reviews' => $reviews,
                ));
            }
        }
        else
        {
            if (!$merchant) {
                return response()->json(array(
                    'status' => 201,
                    'merchant' => 'No merchant found.',
                ));
            } else {
                return response()->json(array(
                    'status' => 200,
                    'merchant' => $merchant,
                    'services' => $services,
                    'reviews' => $reviews,
                    'total_order' => $total_order,
                ));
            }
        }

    }
}


?>
