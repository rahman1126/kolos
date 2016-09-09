<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use Auth;
use Validator;
use Socialite;

class AuthUccul extends Controller
{

    // get gcm id and save it to database
    public function gcm(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'token'     => 'required',
            'regid'     => 'required',
        ]);

        if ($valid->fails())
        {
            return response()->json([
                'error'     => true,
                'status'    => $valid->errors(),
            ]);
        }
        else
        {
            $user = User::find(Auth::user()->id);
            $user->gcm_id = $request->input('regid');
            $newToken = JWTAuth::parseToken()->refresh();
            if ($user->save())
            {
                return response()->json([
                    'status' => 200,
                    'error' => false,
                    'message' => 'Success',
                    'token' => $newToken,
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 201,
                    'error'  => true,
                    'message' => 'Fail',
                    'token' => $newToken,
                ]);
            }
        }

    }

    // register api
    public function register(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'name' => 'required|max:100',
            //'username' => 'required|unique:users,username|max:100',
            'email' => 'required|unique:users,email|max:100',
            'password' => 'required|confirmed|min:4|max:255',
            'phone'     => 'required',
            'location' => 'required|max:255',
        ]);

        if ($valid->fails()) {

            return response()->json(array(
                'status' => 202,
                'msg_status' => $valid->errors()->first(),
            ));
            //return $valid->messages()->toJson();

        } else {

            $user = User::create([
                'name' => $request->input('name'),
                //'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'location' => $request->input('location'),
                'phone' => $request->input('phone'),
            ]);

            if($user)
            {
               return response()->json(array(
                    'status' => 200,
                    'error' => 'Success'
                ));
            }
            else
            {
                return response()->json(array(
                    'status' => 201,
                    'error' => 'Could not create data'
                ));
            }
        }

    }


   // login api
    public function login(Request $request)
    {

        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 202,
                    'error' => 'invalid_credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => 201,
                'error' => 'could_not_create_token'
            ], 500);
        }

        // all good so return the token
        return response()->json([
            'status' => 200,
            'data' => compact('token'),
            'user' => Auth::user(),
        ]);
    }

    // refresh user token and get user data
    // public function getUser(Request $request)
    // {
    //     $newToken = JWTAuth::parseToken()->refresh();
    //     return response()->json([
    //         'data' => Auth::user(),
    //         'newtoken' => $newToken,
    //     ]);
    // }

    // edit user data / update user data
    public function edit(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'name' => 'required',
            //'username' => 'required|unique:users,username,'. Auth::user()->id,
            //'email' => 'required|unique:users,email,'. $request->input('id'),
            'phone' => 'numeric|min:10',
            'location' => 'max:255',
			'home_address' => 'max:255',
			'work_address' => 'max:255',
			'other_address' => 'max:255',
            'avatar' => 'image|max:500|mimes:jpeg,gif,png',
        ]);

        if ($valid->fails()) {

            return response()->json(array(
                'status' => 203,
                'msg_status' => $valid->errors()->first(),
            ));

        } else {

            $user = Auth::user();
            $user->name = $request->input('name');
            //$user->username = $request->input('username');
            //$user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->location = $request->input('location');
			
			$user->home_address = $request->input('home_address');
			$user->home_description = $request->input('home_desscription');
			$user->home_latitude = $request->input('home_latitude');
			$user->home_longitude = $request->input('home_longitude');
			
			$user->work_address = $request->input('work_address');
			$user->work_description = $request->input('work_description');
			$user->work_latitude = $request->input('work_latitude');
			$user->work_longitude = $request->input('work_longiude');
			
			$user->other_address = $request->input('other_address');
			$user->other_description = $request->input('other_description');
			$user->other_latitude = $request->input('other_latitude');
			$user->other_longitude = $request->input('other_longitude');

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


    // login facebook
    public function facebook(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($valid->fails()) {

            return response()->json(array(
                'status' => 203,
                'error' => 'Required few datas'
            ));

        } else {

            $input = $request->all();

            $user = User::where('email', $request->input('email'))->first();
            if ($user) {

                if (!$token = JWTAuth::fromUser($user)) {
                    return response()->json(['result' => 'invalid_credentials']);
                }

                return response()->json([
                    'status' => 200,
                    '_token' => $token,
                    'user' => $user,
                ]);

            } else {

                $user = User::create([
                    'name' => $request->input('name'),
                    'username' => camel_case($request->input('name')),
                    'email' => $request->input('email'),
                    'avatar' => $request->input('photourl'),
                ]);

                if ($user) {

                    $user = User::find($user->id);

                    if (!$token = JWTAuth::fromUser($user)) {
                        return response()->json(['result' => 'invalid_credentials']);
                    }

                    return response()->json([
                        'status' => 200,
                        '_token' => $token,
                        'user' => $user,
                    ]);

                } else {

                    return response()->json([
                        'status' => 201,
                        'error' => 'Cannot save data',
                    ]);

                }

            }

        }
    }

    // login google
    public function google(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($valid->fails()) {

            return response()->json(array(
                'status' => 203,
                'error' => 'Required few datas'
            ));

        } else {

            $user = User::where('email', $request->input('email'))->first();

            if ($user == true) {

                if (!$token = JWTAuth::fromUser($user)) {
                    return response()->json(['result' => 'invalid_credentials']);
                }

                return response()->json([
                    'status' => 200,
                    '_token' => $token . '',
                    'user' => $user,
                ]);

            } else {

                $user = User::create([
                    'name' => $request->input('name'),
                    'username' => camel_case($request->input('name')),
                    'email' => $request->input('email'),
                    'avatar' => $request->input('photourl'),
                ]);

                if ($user) {

                    $user = User::find($user->id);

                    if (!$token = JWTAuth::fromUser($user)) {
                        return response()->json(['result' => 'invalid_credentials']);
                    }

                    return response()->json([
                        'status' => 200,
                        '_token' => $token . '',
                        'user' => $user
                    ]);

                } else {

                    return response()->json([
                        'status' => 201,
                        'error' => 'Cannot save data',
                    ]);

                }

            }

        }
    }


}
