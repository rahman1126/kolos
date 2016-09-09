<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UserMerchant;
use App\FormMerchant;
use App\Vemail;
use App\City;
use App\District;
use App\Service;
use App\Category;

use Validator;
use Session;
use Redirect;
use Auth;

class ProController extends Controller
{
    // step one -------------------
    public function getIndex()
    {

        //Session::flush();
        $categories = Category::all();
        return view('auth.pro.step1')->with('categories', $categories);

    }

    // step one process ***
    public function postNextone(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name'        => 'required|max:100',
            //'last_name'         => 'max:100',
            'email'             => 'required|max:100|email|unique:users,email',
            //'username'        => 'required|min:4|max:100|alpha_num|unique:users,username',
            'password'          => 'required|confirmed|min:6',
            'phone'             => 'required|min:10|max:17',
            'company'           => 'required',
            'category'          => 'required'
        ]);

        if($valid->fails())
        {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }
        else
        {
            //session(['business_name' => $request->input('business_name')]);

            // lets create a new user, new merchant, new merchant form
            $user = new User;
            $user->name         = $request->input('name');
            $user->username     = str_slug($request->input('name') . '_' . mt_rand(1111,9999));
            $user->email        = $request->input('email');
            $user->password     = bcrypt($request->input('password'));
            $user->phone        = str_replace('-', '', str_replace(' ','',$request->input('phone')));
            $user->status       = 1;
            $user->active       = 0;
            $user->phone_validation = mt_rand(11111, 99999);

            if($user->save())
            {
                $newUser = User::find($user->id);

                session(['user_id' => $newUser->id]);

                // create new merchant data
                $merchant = new UserMerchant;
                $merchant->user_id = $user->id;
                $merchant->company = $request->input('company');
                $merchant->category_id = $request->input('category');
                $merchant->default_img = 'logo';
                $merchant->active = 0;
                $merchant->block = 0;
                $merchant->featured = 0;
                $merchant->save();

                // set session so they cant go back to step one
                //$request->session()->put('step', $request->input('two'));
                //session(['step' => '2']);
                session(['merchant_id' => $merchant->id]);

                if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                    // Authentication passed...
                    return redirect('home')
                        ->with('msg', 'You have been succesfully registered, please fill your profile');
                } else {
                    return redirect('home')
                        ->with('msg', 'You have been succesfully registered, please login');
                }

            }
            else
            {
                return redirect()->back()
                    ->with('err', 'Oops, something went wrong. Please try again later.');
            }
        }
    }

    public function getSteplogin()
    {
        return view('auth.pro.stepLogin');
    }

    public function postSteploginprocess(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication passed...

            session(['user_id' => Auth::user()->id]);

            // create new merchant data
            $merchant = new UserMerchant;
            $merchant->user_id = Auth::user()->id;
            $merchant->save();

            session(['merchant_id' => $merchant->id]);

            session(['step' => '2']);
            return redirect('register/pro/two')
                ->with('msg', 'You have been succesfully registered, please continue the next step');
        }
    }

    // step two ---------------------
    public function getTwo()
    {
        session(['step' => '2']);
        $categories = Category::all();
        return view('auth.pro.step2')->with('categories', $categories);

        //return view('auth.pro.step2');
    }


    // step two process ***
    public function postNexttwo(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'business_name'     => 'required|max:100',
            'category'          => 'required',
            'address'           => 'required|max:255',
            'city'              => 'required',
            'district'          => 'required_with:city',
            'postcode'          => 'required|numeric|digits:5',
            'office_number'     => 'required|digits_between:7,12',
            //'website'           => 'active_url|max:100',
            'employees'         => 'required|numeric',
            'area_covered'      => 'required',
        ]);

        if($valid->fails())
        {
            return redirect()->back()
                ->withInput()
                ->withErrors($valid);
        }
        else
        {

            $user = User::find(session('user_id')); // the user

            // lets save the data
            $data = new FormMerchant;
            $data->business_name = $request->input('business_name');
            $data->category = $request->input('category');
            $data->business_address = $request->input('address');
            $data->business_phone = $request->input('office_number');
            $data->name = $user->name;
            $data->phone = $user->phone;
            $data->email = $user->email;
            $data->area_covered = $request->input('area_covered');
            $data->number_employees = $request->input('employees');
            $data->save();

            session(['form_id' => $data->id]);

            $merchant = UserMerchant::find(session('merchant_id'));
            $merchant->company = $request->input('business_name');
            $merchant->location = $request->input('district');
            $merchant->active = 0; // inactive first

            if($merchant->save())
            {
                session(['step' => '3']); // set session

                return redirect('register/pro/three')
                    ->with('msg', 'You almost complete our requirements, please continue the next step');
            }
            else
            {
                return redirect()->back()
                    ->with('err', 'Oops, something went wrong. Please try again.');
            }

        }
    }

    // step three ---------------------
    public function getThree()
    {
            session(['step' => '3']);
            $user = User::find(session('user_id'));
            return view('auth.pro.step3');


    }

    // step three process **
    public function postNextthree(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'open_time'     => 'required',
            'close_time'    => 'required',
            //'description'   => '',
            'logo'          => 'image|max:150|mimes:jpeg,gif,png',
            'cover'         => 'image|max:500|mimes:jpeg,gif,png',
            'website'       => 'active_url|max:100',
        ]);

        if($valid->fails())
        {
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }
        else
        {

            $data = FormMerchant::find(session('form_id'));
            $data->open_time = $request->input('open_time');
            $data->close_time = $request->input('close_time');
            $data->description = $request->input('description');

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');

                if ($request->file('logo')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'logo_' . str_slug($data->business_name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $data->profile_picture = $bg_url;

                }

            }

            if ($request->hasFile('cover')) {
                $image = $request->file('cover');

                if ($request->file('cover')->isValid()) {
                    $directory = public_path() . '/uploads/images/merchant/';
                    $bg_name =  'bg_' . str_slug($data->business_name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/merchant/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $data->cover_picture = $bg_url;

                }

            }

            if ($data->save())
            {

                $data = FormMerchant::find(session('form_id')); // form
                $merchant = UserMerchant::find(session('merchant_id'));
                $merchant->open_time = $data->open_time;
                $merchant->close_time = $data->close_time;
                $merchant->description = $data->description;
                $merchant->logo = $data->profile_picture;
                $merchant->cover = $data->cover_picture;
                $merchant->save();


                session(['step' => '4']); // set session
                return redirect('register/pro/four')
                    ->with('msg', 'Congratulations, you almost done, lets finish this final step');
            }
            else
            {
                return redirect()->back()
                    ->with('err', 'Oops, something went wrong. Please try again.');
            }
        }
    }

    // step four ----------------------
    public function getFour()
    {
        if (session()->has('step'))
        {
            return view('auth.pro.step'. session('step'));
        }
        else
        {
            return view('auth.pro.step1');
        }
        //return view('auth.pro.step4');
    }

    // finish --------------------
    public function postFinish(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'service_name'      => 'max:100',
            //'service_price'     => 'integer',
        ]);

        if ($valid->fails())
        {
            return redirect()->back()
                ->withInput()
                ->withErrors($valid);
        }
        else
        {

            $services = array($request->input('service_name'), $price = $request->input('service_price'),
            $desc = $request->input('service_desc'));
            $servicejson = json_encode($services);

            $form = FormMerchant::find(session('form_id'));
    		$form->services = $servicejson;
            $form->save();

            $service = $request->input('service_name');
            $price = $request->input('service_price');
            $desc = $request->input('service_desc');

            foreach ($service as $key => $n)
            {
                if($n != '')
                {
                    $item = new Service;
                    $item->user_id = session('user_id');
                    $item->name = $n;
                    $item->price = $price[$key];
                    $item->description = $desc[$key];
                    $item->save();
                }

            }

            $user = User::find(session('user_id'));
            $user->active = 1;
            $user->save();

            $this->sendCode();

            return redirect('home') // register/pro/phonevalidation redirect to login while phone validaton empty
                ->with('msg', 'You are kolos merchant now. Lets validate your phone number to activate your account to start selling services.');

        }
    }

    // phone validation
    public function getPhonevalidation()
    {

        if (session()->has('step'))
        {
            $this->sendCode();
            //return view('auth.pro.step'. session('step'));
            return view('auth.pro.phone_validation');
        }
        else
        {
            return view('auth.pro.step1');
        }
        //return view('auth.pro.phone_validation');
    }

    // validate phone
    public function postValidatephone(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'code'  => 'required|numeric|digits:5',
        ]);

        if ($valid->fails())
        {
            return redirect()->back()
                ->withErrors($valid);
        }
        else
        {
            $user = User::find(session('user_id'));

            if ($user->phone_validation == $request->input('code'))
            {
                //$user->active = 1;

                if ($user->save())
                {
                    $merchant = UserMerchant::find(session('merchant_id'));
                    $merchant->active = 1;
                    $merchant->save();

//                    if (Auth::attempt(['email' => $user->email, 'password' => $user->password])) {
//                        // lets forget the session
//                        Session::flush();
//                        return redirect('home')->with('msg','Welcome New Merchant!');
//                    }

                    return redirect('home')
                        ->with('msg', 'Congratulations, your account has been activated. Lets login');
                }
                else
                {
                    return redirect()->back()
                    ->with('err', 'Oops, please try again.');
                }
            }
            else
            {
                return redirect()->back()
                    ->with('err', 'Wrong code.');
            }



        }
    }

    /*
    * Send SMS verification code
    */
    public function sendCode()
    {
        // Send a message to the phone number
        $user = User::find(session('user_id'));
        $api_user = 'APIZ0RGUW235W';
        $api_password = 'APIZ0RGUW235WCYXV3';
        $sms_from = 'KOLOS';
        $sms_to = $user->phone;
        $sms_msg = 'Your KOLOS verification code is '. $user->phone_validation.'.';
        //$this->sendCode($api_user,$api_password,$sms_from,$sms_to,$sms_msg); // callback

        //$user = User::find(session('user_id'));
        $query_string = "api.aspx?apiusername=".$api_user."&apipassword=".$api_password;
        $query_string .= "&senderid=".rawurlencode($sms_from)."&mobileno=".rawurlencode($sms_to);
        $query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";
        $url = "http://gateway.onewaysms.co.id:10002/".$query_string;

        $arr = array($url);
        $fd = implode(',', $arr);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $fd);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
        curl_setopt($curl,CURLOPT_PROXY,'http://proxy.shr.secureserver.net:3128');
        $result = curl_exec($curl);
        curl_close($curl);

        if ($fd) {
            if ($fd > 0) {
                Print("MT ID : " . $fd);
                $ok = "success";
            } else {
                print("Please refer to API on Error : " . $fd);
                $ok = "fail";
            }
        } else {
            // no contact with gateway
            $ok = "fail. No contact";
        }

        return $ok;

    }

    /*
    * GET District
    */
    public function postDistrict(Request $request)
    {
        $country = $request->input('city');

        $districts = District::where('city_id', $country)->orderBy('name', 'ASC')->get();

        if($country !== ''){
                echo "<option value=''>Select</option>";
            foreach($districts as $value){
                echo "<option value='$value->name'>". $value->name . "</option>";
            }
        } else {
            echo "<option>Select</option>";
        }

    }
}
