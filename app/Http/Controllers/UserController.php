<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use Auth;
use File;
use Mail;

use App\User;
use App\Category;
use App\UserMerchant;
use App\Service;
use App\Order;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
    	$users = User::orderBy('status', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(20)->setPath('user');
    	return view('admin.user.view')->with('users', $users);
    }

    // get all admins
    public function getAdmin()
    {
    	$users = User::where('status', 2)->paginate(20)->setPath('admin');
    	return view('admin.user.view')->with('users', $users);
    }

    // get all merchants
    public function getMerchant(Request $request)
    {
        //$username = $request->get('username');
        //->where('username', $username)
    	$users = User::where('status', 1)
            ->orderBy('id','DESC')
            ->paginate(10)->setPath('merchant');
    	return view('admin.user.merchant.view')->with('users', $users);
    }

    /**
     * Create new merchant
     */
    public function getCreatemerchant()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.user.merchant.create')->with('categories', $categories);
    }

    /**
     * Store new merchant data
     */
     public function postStoremerchant(Request $request)
     {
         $valid = Validator::make($request->all(), [
             'name'         => 'required|max:100',
             'username'     => 'required|unique:users,username',
             'email'        => 'required|unique:users,email',
             'phone'        => 'required|min:7|max:17',
             'company'      => 'required|max:100',
             'address'      => 'required|max:255',
             'lat'          => 'required|max:100',
             'lon'          => 'required|max:100',
             'radius'       => 'required',
             'open_time'    => 'required',
             'close_time'   => 'required',
             'location'     => 'required',
             'category'     => 'required',
             //'description'  => 'required',
             'logo'         => 'image|max:2048|mimes:jpeg,gif,png',
             'cover'        => 'image|max:2048|mimes:jpeg,gif,png',
         ]);

         if ($valid->fails()) {
             return redirect()->back()
                ->withErrors($valid)
                ->withInput();
         } else {

             $password = str_random(8);
             // send password to user email
             $user = new User;
             $user->name = $request->input('name');
             $user->username = $request->input('username');
             $user->email = $request->input('email');
             $user->phone = $request->input('phone');
             $user->password = bcrypt($password);
             $user->location = $request->input('location');
             $user->status = 1;

             if ($user->save()) {

                 $merchant = new UserMerchant;
                 $merchant->user_id = $user->id;
                 $merchant->category_id = $request->input('category');
                 $merchant->company = $request->input('company');
                 $merchant->location = $request->input('location');
                 $merchant->location_detail = $request->input('address');
                 $merchant->radius = $request->input('radius');
                 $merchant->lat = $request->input('lat');
                 $merchant->lon = $request->input('lon');
                 $merchant->open_time = $request->input('open_time');
                 $merchant->close_time = $request->input('close_time');
                 $merchant->description = $request->input('description');
                 $merchant->save();

             }

             $user = User::find($user->id);
             Mail::send('emails.newmerchant', array('user' => $user, 'password'=> $password), function($message) use ($user) {
                $message->to($user->email, $user->name)->subject('Welcome to Kolos!');
             });

             return redirect('home/user/merchant')
                ->with('msg', 'Merchant has been added');

         }
     }

    // get all customers
    public function getCustomer()
    {
    	$users = User::where('status', 0)->paginate(20)->setPath('customer');
    	return view('admin.user.view')->with('users', $users);
    }

    // edit user
    public function getEdit($id)
    {
        if ($id != 1) {
            $user = User::find($id);
            if ($user->status == 1) {
                $services = Service::where('user_id', $id)->orderBy('created_at','DESC')->get();
                $orders = Order::where('merchant_id', $id)->orderBy('created_at','DESC')->limit(5)->get();
                $categories = Category::where('active', 1)->get();
                return view('admin.user.edit-merchant')
                    ->with('user', $user)
                    ->with('services', $services)
                    ->with('orders', $orders)
                    ->with('categories', $categories);
            } else {
                return view('admin.user.edit')->with('user', $user);
            }
        } else {

            if (Auth::id() == 1) {
                $user = User::find($id);
                return view('admin.user.edit')->with('user', $user);
            } else {
                return redirect()->back()
                    ->with('msg', 'You cannot edit this user. He is superman.');
            }

        }

    }

    // update user
    public function postUpdate(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'username' => 'required|unique:users,username,'. $request->input('id'),
            'email' => 'required|unique:users,email,'. $request->input('id'),
            'phone' => 'required|min:7|max:17',
            'avatar' => 'image|max:2048|mimes:jpeg,gif,png',
            'password'  => 'min:6|confirmed',
        ]);

        if($valid->fails())
        {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }

        else
        {
            $user = User::find($request->input('id'));
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->phone = str_replace('-', '', str_replace(' ','',$request->input('phone')));
            $user->location = $request->input('location');
            if ($request->input('password') != null) {
                $user->password = bcrypt($request->input('password'));
            }

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');

                if ($request->file('avatar')->isValid()) {
                    $directory = public_path() . '/uploads/images/user/';
                    $bg_name =  'bg_' . str_slug($user->company, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/user/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $user->avatar = $bg_url;

                }

            }

            if($user->save())
            {
                return redirect('home/user' . '/' . ($user->status == 2 ? 'admin' : 'customer'))
                    ->with('msg', 'User has been updated');
            }

            else
            {
                return redirect()->back()
                    ->with('err', 'User cannot be updated');
            }
        }
    }

    public function postUpdatemerchant(Request $request)
    {
        $id = $request->input('usr_id');
        $valid = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'username' => 'required|max:100|unique:users,username,'. $id,
            'email' => 'required|max:100|unique:users,email,'. $id,
            'phone' => 'required|min:7|max:17',
            'company' => 'required|max:255',
            //'description' => 'required',
            'lat'   => 'required',
            'lon'   => 'required',
            'cover' => 'image|max:2048|mimes:jpeg,gif,png',
            'logo' => 'image|max:2048|mimes:jpeg,gif,png',
        ]);

        if ($valid->fails()) {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        } else {

            $user = UserMerchant::find($request->input('id'));
            $user->category_id = $request->input('category');
            $user->company = $request->input('company');
            $user->description = $request->input('description');
            $user->open_time = $request->input('open_time');
            $user->close_time = $request->input('close_time');
            $user->location = $request->input('location');
            $user->location_detail = $request->input('address');
            $user->radius = $request->input('radius');
            $user->lat = $request->input('lat');
            $user->lon = $request->input('lon');
            $user->default_img = $request->input('default_img');

                // save basic user info
                $usr = User::find($user->user_id);
                $usr->name = $request->input('name');
                $usr->username = $request->input('username');
                $usr->email = $request->input('email');
                $usr->phone = str_replace('-', '', str_replace(' ','',$request->input('phone')));
                $usr->save();

            if ($user->save()) {
                return redirect()->back()
                    ->with('msg', 'The merchant has been updated');
            } else {
                return redirect()->back()
                    ->with('err', 'The merchant cannot be updated');
            }

        }
    }

    // Active & Inactive for merchant users
    public function postActive(Request $request)
    {
        $id = $request->input('id');
        $user = UserMerchant::where('user_id', $id)->first();

        $user->active = 1;

        if ($user->save()) {
            return redirect()->back()
                ->with('msg', 'Merchant has been activated');
        } else {
            return redirect()->back()
                ->with('err', 'Merchant cannot be activated');
        }
    }

    public function postInactive(Request $request)
    {
        $id = $request->input('id');
        $user = UserMerchant::where('user_id', $id)->first();

        $user->active = 0;

        if ($user->save()) {
            return redirect()->back()
                ->with('msg', 'Merchant has been deactivated');
        } else {
            return redirect()->back()
                ->with('err', 'Merchant cannot be deactivated');
        }
    }

    // active & inactive for normal users
    public function postIdup(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        $user->active = 1;

        if ($user->save()) {
            return redirect()->back()
                ->with('msg', 'User has been activated');
        } else {
            return redirect()->back()
                ->with('err', 'User cannot be activated');
        }
    }

    public function postMati(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        $user->active = 0;

        if ($user->save()) {
            return redirect()->back()
                ->with('msg', 'User has been deactivated');
        } else {
            return redirect()->back()
                ->with('err', 'User cannot be deactivated');
        }
    }

    public function postFeatured(Request $request)
    {
        $id = $request->input('id');
        $user = UserMerchant::where('user_id', $id)->first();

        $user->featured = 1;

        if ($user->save()) {
            return redirect()->back()
                ->with('msg', 'Merchant has been set as featured');
        } else {
            return redirect()->back()
                ->with('err', 'Merchant cannot be set as featured');
        }
    }

    public function postUnfeatured(Request $request)
    {
        $id = $request->input('id');
        $user = UserMerchant::where('user_id', $id)->first();

        $user->featured = 0;

        if ($user->save()) {
            return redirect()->back()
                ->with('msg', 'Merchant has been set as unfeatured');
        } else {
            return redirect()->back()
                ->with('err', 'Merchant cannot be set as unfeatured');
        }
    }

    // assign user as merchant
    public function postAssignasmerchant(Request $request)
    {
    	$id = $request->input('id');
    	$user = User::find($id);
    	$user->status = 1;

        $merchant = new UserMerchant;
        $merchant->user_id = $id;
        $merchant->save();

    	if ($user->save()) {

    		return redirect()->back()
    			->with('msg', $user->name. ' has been assigned to merchant');
    	} else {
    		return redirect()->back()
    			->with('err', $user->name. ' cannot be assigned as merchant');
    	}
    }

    // assign user to customer
    public function postAssignascustomer(Request $request)
    {
    	$id = $request->input('id');
    	$user = User::find($id);
    	$user->status = 0;

        $merchant = UserMerchant::where('user_id', $id)->first();
        $merchant->delete();

    	if ($user->save()) {
    		return redirect()->back()
    			->with('msg', $user->name. ' has been assigned to customer');
    	} else {
    		return redirect()->back()
    			->with('err', $user->name. ' cannot be assigned as customer');
    	}
    }

    public function postUploadimageuser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:jpg,jpeg,gif,png|image|max:500'
        ]);

        if ($validator->fails())
        {
            return response()->json(asset('error'));
        }
        else
        {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                if ($request->file('avatar')->isValid()) {
                    $directory = public_path() . '/uploads/images/user/';
                    $bg_name =  'avatar_' . $request->input('id') . '_' . str_slug($request->input('name'), "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/user/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);

                    $user = User::find($request->input('id'));
                    $user->avatar = $bg_url;
                    $user->save();

                    return response()->json(asset($bg_url));
                }
            }
        }
    }

    public function postUploadlogomerchant(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:jpg,jpeg,gif,png|image|max:500'
        ]);

        if ($validator->fails())
        {
            return response()->json(asset('error'));
        }
        else
        {
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                if ($request->file('logo')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'logo_' . $request->input('id') . '_' . str_slug($request->input('name'), "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);

                    $user = UserMerchant::find($request->input('id'));
                    $user->logo = $bg_url;
                    $user->save();

                    return response()->json(asset($bg_url));
                }
            }
        }
    }

    public function postUploadcovermerchant(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:jpg,jpeg,gif,png|image|max:500'
        ]);

        if ($validator->fails())
        {
            return response()->json(asset('error'));
        }
        else
        {
            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                if ($request->file('cover')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'cover_' . $request->input('id') . '_' . str_slug($request->input('name'), "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);

                    $user = UserMerchant::find($request->input('id'));
                    $user->cover = $bg_url;
                    $user->save();

                    return response()->json(asset($bg_url));
                }
            }
        }
    }

    // delete user
    public function postDelete(Request $request)
    {
    	$id = $request->input('id');
    	$user = User::find($id);

        if ($user->status == 1) {
            $merchant = UserMerchant::where('user_id', $id)->first();
            $merchant->delete();
        }

    	if ($user->delete()) {
    		return redirect()->back()
    		->with('msg', 'User has been deleted');
    	} else {
    		return redirect()->back()
    		->with('err', 'User cannot be deleted');
    	}

    }
}
