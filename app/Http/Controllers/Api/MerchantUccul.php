<?php

namespace App\Http\Controllers\Api;

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

use Auth;
use Validator;

class MerchantUccul extends Controller
{
    public function __construct()
    {
    	//$this->middleware('jwt.auth');
    }

    public function postRequest(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'email|required|max:100|unique:pro_request,email',
            'phone' => 'required|max:15|unique:pro_request,phone',
        ]);

        if($valid->fails()){

            return response()->json([
               'status' => 400,
               'msg_status' => $valid->errors()->first(),
            ]);

        } else {

            $pro = new ProRequest;
            $pro->name = $request->input('name');
            $pro->email = $request->input('email');
            $pro->phone = $request->input('phone');

            if($pro->save())
            {
                return response()->json([
                   'status' => 200,
                   'msg_status'  => 'Request has been sent',
                ]);
            }
            else
            {
                return response()->json([
                   'status' => 201,
                   'msg_status'  => 'Failed',
                ]);
            }

        }


    }


    //  get all merchants
    public function getAll()
    {
    	$merchants = UserMerchant::where('active', 1)->get();
        if ($merchants->isEmpty()) {
            return response()->json(array(
                'status' => 201,
                'merchants' => 'No merchant found.',
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'merchants' => $merchants,
            ));
        }
    }

    // merchant detail
    public function getDetail(Request $request)
    {
    	$id = $request->input('id');
        $merchant = UserMerchant::where('active', 1)
            ->where('user_id', $id)->first();
        $services = Service::where('user_id', $id)->get();
        $reviews = Review::select('reviews.*','users.avatar','users.name','feedbacks.comment as merchant_feedback')
            ->where('reviews.merchant_id', $id)
            ->leftJoin('feedbacks','feedbacks.order_id','=','reviews.order_id')
            ->leftJoin('users','users.id','=','reviews.customer_id')
            ->orderBy('created_at', 'DESC')
            ->get();
        //$number_votes = Review::where('merchant_id', $id)->get()->count();
        //$user = User::find($request->input('id'));

        if (!$merchant)
        {
            return response()->json([
                'status' => 401,
                'error' => 'He is not a merchant',
            ]);
        }

        //$merchant['total_reviews'] = $number_votes;

        if($reviews->isEmpty())
        {
            $reviews = '[]';

        }

        if($services->isEmpty())
        {
            $services = '[]';
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
                ));
            }
        }

    }

    // get top merchants
    public function getFeatured()
    {
    	$merchants = UserMerchant::where('active', 1)
    		->where('featured', 1)
    		->get();
        if ($merchants->isEmpty()) {
            return response()->json(array(
                'status' => 201,
                'merchants' => 'No merchant found.',
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'merchants' => $merchants,
            ));
        }

    }


    // get list of favorites merchants
    public function getFavorites(Request $request)
    {

        $id = Auth::user()->id;
        $favorites = Favorite::select('favorite_user.id', 'favorite_user.user_id as userid', 'favorite_user.merchant_id', 'user_merchant.*')
            ->where('favorite_user.user_id', $id)
            //->leftJoin('users', 'users.id', '=', 'favorite_user.merchant_id')
            ->leftJoin('user_merchant', 'user_merchant.user_id', '=', 'favorite_user.merchant_id')
            ->get();
        if ($favorites->isEmpty()) {
            return response()->json(array(
                'status' => 201,
                'favorites' => 'No favorites merchant yet.',
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'favorites' => $favorites,
            ));
        }

    }

    // the magic search
    public function getSearch(Request $request)
    {
        $query = Service::query();

        if ($request->has('keywords'))
        {
            $key = $request->input('keywords');
            $query->where('name','like',"%$key%");
            $query->orWhere('description','like',"%$key%");
        }

        $results = $query->orderBy('name', 'ASC')->get();

        return response()->json([
            'status'    => '200',
            'data'      => $results
        ]);
    }


    public function addFavorite(Request $request)
    {
        // params ['token','merchant_id'];

        $user_id = Auth::user()->id;
        $merchant_id = $request->input('merchant_id');

        $favorited = Favorite::where('user_id', $user_id)->where('merchant_id', $merchant_id)->first();

        if ($favorited) {
            $favorite = $favorited;
        } else {
            $favorite = new Favorite;
        }
        $favorite->user_id = $user_id;
        $favorite->merchant_id = $merchant_id;
        if ($favorite->save()) {
            return response()->json(array(
                'status' => 200,
                'data' => 'successful added to favorite',
            ));
        } else {
            return response()->json(array(
                'status' => 201,
                'data' => 'cannot add to favorite',
            ));
        }
    }


    public function removeFavorite(Request $request)
    {
        // params ['token','merchant_id'];

        $user_id = Auth::user()->id;
        $merchant_id = $request->input('merchant_id');

        $user = Favorite::where('user_id', $user_id)
            ->where('merchant_id', $merchant_id)->first();
        if ($user->delete()) {
            return response()->json(array(
                'status' => 200,
                'data' => 'successful remove favorite',
            ));
        } else {
            return response()->json(array(
                'status' => 201,
                'data' => 'failed to remove favorite',
            ));
        }
    }
}
