<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Review;
use App\Feedback;
use App\UserMerchant;
use App\Order;
use App\User;
use App\Alert;

use Validator;
use Auth;

class ReviewUccul extends Controller
{

    public function getReviews(Request $request)
    {
        $reviews = Review::where('merchant_id', $request->input('merchant_id'))->get();
        $feedback = Feedback::where('merchant_id', $request->input('merchant_id'))->first();
        if (!$reviews->isEmpty()) {
            return response()->json(array(
                'status' => 200,
                'review' => $reviews,
                'feedback' => $feedback,
            ));
        } else {
            return response()->json(array(
                'status' => 201,
                'review' => 'No reviews yet',
            ));
        }
    }

    public function getLastreview(Request $request)
    {
        $lastOrder = Order::where('user_id', Auth::user()->id)
            ->where('status', 2) // check if status is complete
            ->orderBy('id', 'DESC')->first();
        $review = Review::where('order_id', $lastOrder['id'])->first();

        if ($review == null)
        {
            $merchant = UserMerchant::where('user_id', $lastOrder['merchant_id'])->first();
            $lastOrder['merchant_name'] = $merchant['company'];
            return response()->json([
                'status'                => 200,
                'review_data'           => null,
                'last_complete_order'   => $lastOrder,
            ]);
        }
        else
        {
            $merchant = UserMerchant::where('user_id', $review['merchant_id'])->first();
            $review['merchant_name'] = $merchant['company'];
            return response()->json([
               'status'     => 201,
                'review_data'      => $review,
            ]);
        }
    }

    public function postReview(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'id'    => 'required|integer',
            'merchant_id'   => 'required|integer',
            'comment'       => 'max:255',
            'rating'        => 'required',
        ]);

        if($valid->fails())
        {
            return response()->json([
               'status' => 400,
               'errors' => $valid->errors(),
            ]);
        }
        else {
            //$merchant_id = $request->input('merchant_id');
            $user_id = Auth::user()->id;
            $review = new Review;
            $review->order_id = $request->input('id');
            $review->customer_id = $user_id;
            $review->merchant_id = $request->input('merchant_id');
            $review->comment = $request->input('comment');
            $review->rating = $request->input('rating');

            if ($review->save()) {

                $merchant = UserMerchant::where('user_id', $request->input('merchant_id'))->first();
                $number_votes = Review::where('merchant_id', $request->input('merchant_id'))->get()->count();
                $points = Review::select('rating')->where('merchant_id', $request->input('merchant_id'))->get();
                if ($points->isEmpty()) {
                    $merchant->rating = $request->input('rating');
                    $merchant->save();

                    // save alert notification
                    $user = User::find($user_id);
                    $alert = new Alert;
                    $alert->user_id = $merchant_id;
                    $alert->message = 'You get new review from '. $user->name .'. You can check it and reply in your profile.';
                    $alert->icon = '1';
                    $alert->save();

                    return response()->json(array(
                        'status' => 200,
                        'data' => 'Review successfully saved',
                    ));

                } else {
                    $points_count = 0;
                    foreach ($points as $point) {
                        $points_count += $point->rating;
                    }
                    $total_points = $points_count;
                    $merchant->rating = round($total_points / $number_votes, 1);
                    $merchant->total_reviews = $number_votes + 1;
                    $merchant->save();

                    // save alert notification
                    $user = User::find($user_id);
                    $alert = new Alert;
                    $alert->user_id = $merchant->id;
                    $alert->message = 'You get new review from '. $user->name .'. You can check it and reply in your profile.';
                    $alert->icon = '1';
                    $alert->save();

                    return response()->json(array(
                        'status' => 200,
                        'data' => 'Review successfully saved',
                    ));
                }

            } else {
                return response()->json(array(
                    'status' => 201,
                    'data' => 'Review cannot be saved',
                ));
            }
        }

    }

    // post feedback by merchant
    public function postFeedback(Request $request)
    {
        if (Auth::user()->status != 1)
        {
            return response()->json([
                'error' => 1,
                'data'  => 'Youre not a merchant',
            ]);
        }

        $ID = Auth::user()->id;

        $feedback = new Feedback;
        $feedback->order_id = $request->input('id');
        $feedback->merchant_id = $ID;
        $feedback->comment = $request->input('comment');

        if ($feedback->save()) {

            // save alert notification
            $user = UserMerchant::find($ID);
            $alert = new Alert;
            $alert->user_id = $ID;
            $alert->message = 'You get new feedback from '. ($user->company == '' ? 'The Merchant' : $user->company) .'. You can check it from order page.';
            $alert->icon = '1';
            $alert->save();

            return response()->json(array(
                'status' => 200,
                'data' => 'Feedback successfully saved',
            ));
        } else {
            return response()->json(array(
                'status' => 201,
                'data' => 'Feedback cannot be saved',
            ));
        }
    }
}
