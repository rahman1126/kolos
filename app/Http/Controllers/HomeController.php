<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Order;
use App\User;
use App\Service;
use App\Category;
use App\UserMerchant;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->status == 2) {
            $merchants = UserMerchant::where('lat','<>','')->where('lon','<>','')->get();
            $merchantNum = UserMerchant::where('lat','<>','')->where('lon','<>','')->count();
            return view('admin.dashboard.view')
                ->with('merchants', $merchants)
                ->with('merchantNum', $merchantNum);

        } elseif(Auth::user()->status == 1){

            $services = Service::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
            $orders = Order::where('merchant_id', Auth::id())
                ->orderBy('created_at','DESC')->limit(5)->get();
            $categories = Category::where('active', 1)->get();
            return view('admin.user.public.edit-merchant')
                ->with('user', User::find(Auth::id()))
                ->with('orders', $orders)
                ->with('services', $services)
                ->with('categories', $categories);

            // if ($request->has('status')) {
            //     if ($request->input('status') == 'current') {
            //         $orders = Order::where('merchant_id', Auth::id())
            //             ->where('status', 0)
            //             ->orWhere('status', 1)
            //             ->orderBy('created_at','DESC')
            //             ->paginate(20)->setPath('home/order');
            //     } elseif ($request->input('status') == 'past') {
            //         $orders = Order::where('merchant_id', Auth::id())
            //             ->where('status', 2)
            //             ->orWhere('status', 3)
            //             ->orderBy('created_at','DESC')
            //             ->paginate(20)->setPath('home/order');
            //     } else {
            //         $orders = Order::where('merchant_id', '=', Auth::id())
            //            ->where(function ($query) {
            //                $query->where('status', '=', 0)
            //                      ->orWhere('status', '=', 1);
            //            })
            //            ->orderBy('created_at', 'DESC')
            //            ->paginate(20)->setPath('home/order');
            //     }
            // } else {
            //     $orders = Order::where('merchant_id', '=', Auth::id())
            //        ->where(function ($query) {
            //            $query->where('status', '=', 0)
            //                  ->orWhere('status', '=', 1);
            //        })
            //        ->orderBy('created_at', 'DESC')
            //        ->paginate(20)->setPath('home');
            // }
            // return view('admin.dashboard.public_view')->with('orders', $orders);

        } else {

            if ($request->input('status') == 'current') {
                $orders = Order::where('user_id', Auth::id())
                    ->where('status', 0)
                    ->orWhere('status', 1)
                    ->orderBy('created_at','DESC')
                    ->paginate(20)->setPath('home/order');
            } elseif ($request->input('status') == 'completed') {
                $orders = Order::where('user_id', Auth::id())
                    ->where('status', 2)
                    ->orWhere('status', 3)
                    ->orderBy('created_at','DESC')
                    ->paginate(20)->setPath('home/order');
            } else {
                $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at','DESC')
                    ->paginate(20)->setPath('home/order');
            }

            $user = Auth::user();
            return view('admin.user.public.edit')->with('user', $user);
        }
    }

    // become a Profesional
    public function getBecomePro()
    {
        $categories = Category::where('active', 1)->get();
        return view('admin.user.public.create')->with('categories', $categories);
    }

    // post become a profesional form
    public function postBecomePro(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'company'   => 'required',
            'address'   => 'required',
            'radius'    => 'required|integer',
            'location'  => 'required',
            'category'  => 'required',
            'open_time' => 'required',
            'close_time'    => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        } else {

            $merchant = new UserMerchant;
            $merchant->user_id = Auth::id();
            $merchant->company = $request->input('company');
            $merchant->location = $request->input('location');
            $merchant->location_detail = $request->input('address');
            $merchant->lat = $request->input('lat');
            $merchant->lon = $request->input('lon');
            $merchant->radius = $request->input('radius');
            $merchant->category_id = $request->input('category');
            $merchant->open_time = $request->input('open_time');
            $merchant->close_time = $request->input('close_time');
            $merchant->description = $request->input('description');
            $merchant->default_img = 'logo';
            $merchant->active = 0;
            $merchant->block = 0;
            $merchant->featured = 0;

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');

                if ($request->file('logo')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'logo_' . str_slug($merchant->company, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $merchant->logo = $bg_url;

                }

            }

            if ($request->hasFile('cover')) {
                $image = $request->file('cover');

                if ($request->file('cover')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'bg_' . str_slug($merchant->company, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_urls = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $merchant->cover = $bg_urls;

                }

            }

            if ($merchant->save()) {

                $user = User::find(Auth::id());
                $user->status = 1;
                $user->save();

                return redirect('home')
                    ->with('msg', 'Request succesfully sent');

            } else {

                return redirect()->back()
                    ->with('err', 'Oops, please try again');
            }

        }
    }

    // view user profile
    public function getViewProfile($id)
    {
        $user = User::find($id);
        $orders = Order::where('user_id', $id)->where('merchant_id', Auth::id())->paginate('10');
        return view('admin.user.profile')
            ->with('orders', $orders)
            ->with('user', $user);
    }

    // view company data
    public function getViewCompany($id)
    {
        $user = User::find($id);
        $categories = Category::where('active', 1)->get();
        $orders = Order::where('user_id', Auth::id())->where('merchant_id', $id)->get();
        $services = Service::where('user_id', $id)->get();
        return view('admin.user.company')
            ->with('categories', $categories)
            ->with('orders', $orders)
            ->with('services', $services)
            ->with('user', $user);
    }

    // edit profile
    public function getProfile()
    {
        $user = User::find(Auth::id());
        return view('admin.user.public.edit')->with('user', $user);

    }

    public function getMerchantprofile()
    {
        $services = Service::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
        $orders = Order::where('merchant_id', Auth::id())
            ->orderBy('created_at','DESC')->limit(5)->get();
        $categories = Category::where('active', 1)->get();
        return view('admin.user.public.edit-merchant')
            ->with('user', User::find(Auth::id()))
            ->with('orders', $orders)
            ->with('services', $services)
            ->with('categories', $categories);
    }

    // update profile except merchant user
    public function postProfile(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'username' => 'required|alpha_num|unique:users,username,'. $request->input('id'),
            'email' => 'required|unique:users,email,'. $request->input('id'),
            'phone' => 'required|min:7|max:17',
            'password' => 'confirmed|min:6',
            'avatar' => 'image|max:2048|mimes:jpeg,gif,png',
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
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->phone = str_replace('-', '', str_replace(' ','',$request->input('phone')));
            $user->location = $request->input('location');

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
                return redirect()->back()
                    ->with('msg', 'User has been updated');
            }

            else
            {
                return redirect()->back()
                    ->with('err', 'User cannot be updated');
            }
        }
    }

    // update merchant
    public function postMerchant(Request $request)
    {
        $id = $request->input('usr_id');
        $valid = Validator::make($request->all(), [
            //'name' => 'required|max:100',
            //'username' => 'required|max:100|unique:users,username,'. $id,
            //'email' => 'required|max:100|unique:users,email,'. $id,
            //'phone' => 'required|min:7|max:17',
            //'password' => 'confirmed|min:6',
            'company' => 'required|max:255',
            'location' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'radius'    => 'required|min:2',
            //'description' => 'required',
            //'lat'   => 'required',
            //'lon'   => 'required',
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

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');

                if ($request->file('logo')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'logo_' . str_slug($user->company, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $user->logo = $bg_url;

                }

            }

            if ($request->hasFile('cover')) {
                $image = $request->file('cover');

                if ($request->file('cover')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'bg_' . str_slug($user->company, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $user->cover = $bg_url;

                }

            }

                // save basic user info
                // $usr = User::find($user->user_id);
                // $usr->name = $request->input('name');
                // $usr->username = $request->input('username');
                // $usr->email = $request->input('email');
                // if ($request->has('password')) {
                //     $usr->password = bcrypt($request->input('password'));
                // }
                // $usr->phone = str_replace('-', '', str_replace(' ','',$request->input('phone')));
                // $usr->save();

            if ($user->save()) {
                return redirect()->back()
                    ->with('msg', 'The merchant has been updated');
            } else {
                return redirect()->back()
                    ->with('err', 'The merchant cannot be updated');
            }

        }
    }
}
