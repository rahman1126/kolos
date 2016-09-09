<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use Auth;

use App\FormMerchant;
use App\User;
use App\ProRequest;
use App\FormMerchantService;

class FormController extends Controller
{

    public function getIndex()
    {
        if (!Auth::check())
        {
            return redirect('login');
        }

        $forms = FormMerchant::paginate(20)->setPath('form');
        $prorequest = ProRequest::all();
        return view('admin.form.view')
            ->with('forms', $forms)
            ->with('requests', $prorequest);
    }

    public function getDetail($id)
    {
        if (!Auth::check())
        {
            return redirect('login');
        }

        $form = FormMerchant::find($id);
        return view('admin.form.detail')->with('form', $form);
    }

    public function submit(Request $request)
    {

    	$valid = Validator::make($request->all(), [
    		'business_name' => 'required',
    		'email' => 'unique:form_merchant,email',
    		'username' => 'unique:form_merchant,username',
    		//'profile_picture' => 'image|max:2048|mimes:jpeg,gif,png',
    	]);

    	if ($valid->fails()) {

            return response($valid->errors()->all());

    	} else {

    		$user = new FormMerchant;
    		$user->business_name = $request->input('business_name');
    		$user->category = $request->input('category');
    		$user->business_address = $request->input('business_address');
    		$user->business_phone = $request->input('business_phone');
    		$user->name = $request->input('name');
    		$user->phone = $request->input('phone');
    		$user->email = $request->input('email');
    		$user->description = $request->input('description');
    		$user->open_time = $request->input('open_time');
    		$user->close_time = $request->input('close_time');
    		$user->area_covered = $request->input('area_covered');
    		$user->number_employees = $request->input('number_employees');

            $services = array($request->input('service'));
            $servicejson = json_encode($services);

    		$user->services = $servicejson;
    		$user->email_registration = $request->input('email_registration');
    		$user->username = $request->input('username');
    		$user->password = $request->input('password');
    		$user->mobile = $request->input('mobile');


    		if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');

                if ($request->file('profile_picture')->isValid()) {
                    $directory = public_path() . '/uploads/images/form/';
                    $bg_name =  'bg_' . str_slug($category->name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/form/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $user->profile_picture = $bg_url;

                }

            }

            $user->save();

            return response('Your data has been saved');

    	}
    }
}
