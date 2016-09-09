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
use Socialite;

/**
 * Auth Ctrl
 */
class AuthCtrl extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    // Register
    public function register(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|max:100',
            //'username' => 'required|unique:users,username|max:100',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|confirmed|min:4|max:255',
            'phone'     => 'required',
            'location' => 'required|max:255',
        ]);

        if ($valid->fails()) {

            return response()->json($valid->errors()->first());
            //return $valid->messages()->toJson();

        } else {

            $user = User::create([
                'avatar' => 'https://cdn0.vox-cdn.com/images/verge/default-avatar.v9899025.gif',
                'name' => $request->input('name'),
                'username' => camel_case($request->input('name')) . time(),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'location' => $request->input('location'),
                'phone' => $request->input('phone'),
            ]);

            if($user)
            {
               return response()->json('200');
            }
            else
            {
                return response()->json('201');
            }
        }
    }


}


?>
