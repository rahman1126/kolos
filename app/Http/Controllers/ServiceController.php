<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Service;
use App\UserMerchant;

use Auth;
use Validator;

class ServiceController extends Controller
{
    public function __construct()
    {
    	return $this->middleware('auth');
    }

    public function getIndex()
    {
    	if (Auth::user()->status == 2) {
    		$services = Service::paginate(10)->setPath('service');
    		return view('admin.service.view')->with('services', $services);
    	} elseif(Auth::user()->status == 1) {
    		$services = Service::where('user_id', Auth::id())->paginate(10)->setPath('service');
    		return view('admin.service.view')->with('services', $services);
    	} else {
    		return view('customer.service.view');
    	}
    }

    public function getCreate()
    {
        $merchants = UserMerchant::where('block', 0)
            ->where('company', '<>', '')
            ->where('active', 1)->get();
    	return view('admin.service.create')->with('merchants', $merchants);
    }

    public function postStore(Request $request)
    {
    	$valid = Validator::make($request->all(), [
    		'name' => 'required|max:100',
    		'description' => 'required|max:255',
    		'price' => 'required|numeric',
    		'image' => 'image|max:2048|mimes:jpeg,gif,png',
    	]);

    	if ($valid->fails()) {
    		return redirect()->back()
    			->withInput()
    			->withErrors($valid);
    	} else {

    		$service = new Service;
            if ($request->input('user_id') != '') {
                $service->user_id = $request->input('user_id');
            } else {
                $service->user_id = Auth::id();
            }

    		$service->name = $request->input('name');
    		$service->description = $request->input('description');
    		$service->price = $request->input('price');

    		if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($request->file('image')->isValid()) {
                    $directory = public_path() . '/uploads/images/service/';
                    $img_name =  'img_' . str_slug($service->name, "_") .'.'. $image->getClientOriginalExtension();
                    $img_url = url('/uploads/images/service/'. $img_name);

                    $moved = $image->move($directory, $img_name);
                    $service->image = $img_url;

                }

            }

            if ($service->save()) {
            	return redirect('home/service')
            		->with('msg', 'Your service has been created');
            } else {
            	return redirect()->back()
            		->with('err', 'Your service cannot be created');
            }

    	}
    }

    // for ajax request
    public function postAjaxstore(Request $request)
    {

        $userID = $request->input('user_id');
        $sname = $request->input('name');
        $sdescription = $request->input('description');
        $sprice = $request->input('price');

        $service = new Service;
        $service->user_id = $userID;
        $service->name = $sname;
        $service->description = $sdescription;
        $service->price = $sprice;

        if ($service->save()) {
            return response()->json($service);
        } else {
            return response()->json([
                'error'     => true,
                'data'      => null,
            ]);
        }

    }


    public function getEdit($id)
    {
    	$service = Service::where('id', $id)->first();
        $merchants = UserMerchant::where('block', 0)
            ->where('company', '<>', '')
            ->where('active', 1)->get();
    	return view('admin.service.edit')->with('service', $service)
            ->with('merchants', $merchants);
    }

    public function postUpdate(Request $request)
    {
    	$valid = Validator::make($request->all(), [
    		'name' => 'required|max:100',
    		'description' => 'required|max:255',
    		'price' => 'required|numeric',
    		'image' => 'image|max:2048|mimes:jpeg,gif,png',
    	]);

    	if ($valid->fails()) {
    		return redirect()->back()
    			->withInput()
    			->withErrors($valid);
    	} else {

    		$service = Service::find($request->input('id'));
    		if ($request->input('user_id') != '') {
                $service->user_id = $request->input('user_id');
            } else {
                $service->user_id = Auth::id();
            }
    		$service->name = $request->input('name');
    		$service->description = $request->input('description');
    		$service->price = $request->input('price');

    		if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($request->file('image')->isValid()) {
                    $directory = public_path() . '/uploads/images/service/';
                    $img_name =  'img_' . str_slug($service->name, "_") .'.'. $image->getClientOriginalExtension();
                    $img_url = url('/uploads/images/service/'. $img_name);

                    $moved = $image->move($directory, $img_name);
                    $service->image = $img_url;

                }

            }

            if ($service->save()) {
            	return redirect('home/service')
            		->with('msg', 'Your service has been created');
            } else {
            	return redirect()->back()
            		->with('err', 'Your service cannot be created');
            }

    	}
    }

    public function postDelete(Request $request)
    {
    	$id = $request->input('id');
    	$service = Service::where('id', $id)->first();

    	if ($service->delete()) {
    		return redirect()->back()
    		->with('msg', 'Service has been deleted');
    	} else {
    		return redirect()->back()
    		->with('err', 'Service cannot be deleted');
    	}
    }
}
