<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;

use Auth;
use Validator;

/**
 * User Ctrl
 */
class UserCtrl extends Controller
{

    public function profile(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        if ($user != null) {
            return response()->json($user);
        } else {
            return response()->json('oops');
        }
    }

    // edit user data / update user data
    public function profileEdit(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'name' => 'required',
            //'username' => 'unique:users,username,'. Auth::user()->id,
            //'email' => 'required|unique:users,email,'. $request->input('id'),
            'phone' => 'numeric|min:10',
            'location' => 'max:255',
            'avatar' => 'image|max:500|mimes:jpeg,gif,png',
        ]);

        if ($valid->fails()) {

            return response()->json(array(
                'status' => 203,
                'error' => $valid->errors(),
            ));

        } else {

            $user = Auth::user();
            $user->name = $request->input('name');
            //$user->username = $request->input('username');
            //$user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->location = $request->input('location');

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');

                if ($request->file('avatar')->isValid()) {
                    $directory = public_path() . '/uploads/images/user/';
                    $img_name =  'img_' . str_slug($user->name, "_") .'.'. $image->getClientOriginalExtension();
                    $img_url = url('/uploads/images/user/'. $img_name);

                    $moved = $image->move($directory, $img_name);
                    $user->avatar = $img_url;

                }

            }

            if ($user->save()) {
                $user = User::find($user->id);
                return response()->json([
                    'status' => 200,
                    'message' => 'Your data has been changed',
                    'user' => $user,
                ]);

            } else {

                return response()->json([
                    'status' => 201,
                    'user' => 'Your data cannot be saved',
                ]);

            }

        }
    }


    public function upload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:jpg,jpeg,gif,png|image'
        ]);

        if ($validator->fails())
        {
            return response()->json(asset('error'));
        }
        else
        {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                if ($request->file('file')->isValid()) {
                    $directory = public_path() . '/uploads/images/profile/';
                    $bg_name =  'avatar_' . time() .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/profile/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);

                    $user = User::find(Auth::id());
                    $user->avatar = $bg_url;
                    //$user->location = $request->input('location');
                    $user->save();

                    return response()->json([
                        'status' => 200,
                        'avatar' => $bg_url,
                    ]);
                }
            }
        }
    }

}


?>
