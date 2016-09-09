<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use App\Favorite;
use App\Alert;

use Auth;
use Validator;

/**
 * Follower Controllers
 */
class FollowerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {

        $followers = Favorite::join('users', 'users.id', '=', 'favorite_user.user_id')
                                ->where('favorite_user.merchant_id', Auth::user()->id)
                                ->where('favorite_user.user_id', '<>', Auth::user()->id)
                                ->get();
        return view('merchant.follower.view')->with('followers', $followers);
    }

    /**
     * Get view to push alert
     */
     public function getCreate()
     {
         return view('merchant.follower.create');
     }

     public function postStore(Request $request)
     {
         $valid = Validator::make($request->all(), [
             'message'      => 'required',
         ]);

         if ($valid->fails()) {
             return redirect()->back()
                ->withErrors($valid)
                ->withInput();
         } else {

             $followers = Favorite::join('users', 'users.id', '=', 'favorite_user.user_id')
                                     ->where('favorite_user.merchant_id', Auth::user()->id)
                                     ->where('favorite_user.user_id', '<>', Auth::user()->id)
                                     ->get();
             $message = $request->input('message');

             foreach ($followers as $follower) {
                 $alert = new Alert;
                 $alert->message = User::find(Auth::id())->merchant->company . ': ' . $message;
                 $alert->order_id = 0;
                 $alert->user_id = $follower->user_id;
                 $alert->icon = 2;
                 $alert->read = 0;
                 $alert->save();
             }

             return redirect()->back()
                ->with('msg', 'Message has been pushed to followers');

         }
     }
}


?>
