<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Slideshow;

use Validator;

class SlideshowController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /*
     * View all
     */
    public function getIndex()
    {
    	$sliders = Slideshow::all();
    	return view('admin.slideshow.view')
    		->with('sliders', $sliders);
    }

    /*
     * Create form
     */
    public function getCreate()
    {
    	return view('admin.slideshow.create');
    }
    
    /*
    * Create store
    */
    public function postStore(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name'  =>  'max:100',
            'description'   =>  'max:255',
            'image' => 'required|image|max:500|mimes:jpeg,gif,png',
        ]);
        
        if($valid->fails())
        {
            return redirect()->back()
                ->withInput()
                ->withErrors($valid);
        }
        else
        {
            $slider = new Slideshow;
            if ($request->has('name'))
            {
                $slider->name = $request->input('name');
            }
            if ($request->has('description'))
            {
                $slider->description = $request->input('description');
            }
            
            if($request->hasFile('image'))
            {
                $img = $request->file('image');
                if($img->isValid())
                {
                    $directory = public_path() . '/uploads/images/slider/';                    
                    $img_name =  'img_' . mt_rand(1111,999999999) .'.'. $img->getClientOriginalExtension();
                    $img_url = url('/uploads/images/slider/'. $img_name);
                    
                    $moved = $img->move($directory, $img_name);
                    $slider->image = $img_url;
                }
            }
            
            if($slider->save())
            {
                return redirect('home/slideshow')
                    ->with('msg', 'Slider has been saved');
            }
            else
            {
                return redirect()->back()
                    ->with('err', 'Slider cannot be saved. Please try again');
            }
        }
    }
    
    /*
    * Edit form
    */
    public function getEdit($id)
    {
        $slider = Slideshow::find($id);
        return view('admin.slideshow.edit')
            ->with('slider',$slider);
    }
    
    /*
    * EDit update
    */
    public function postUpdate(Request $request)
    {
        
        $valid = Validator::make($request->all(), [
            'name'  =>  'max:100',
            'description'   =>  'max:255',
            'image' => 'image|max:500|mimes:jpeg,gif,png',
        ]);
        
        if($valid->fails())
        {
            return redirect()->back()
                ->withInput()
                ->withErrors($valid);
        }
        else
        {
            $slider = Slideshow::find($request->input('id'));
            if ($request->has('name'))
            {
                $slider->name = $request->input('name');
            }
            if ($request->has('description'))
            {
                $slider->description = $request->input('description');
            }
            
            if($request->hasFile('image'))
            {
                $img = $request->file('image');
                if($img->isValid())
                {
                    $directory = public_path() . '/uploads/images/slider/';                    
                    $img_name =  'img_' . mt_rand(1111,999999999) .'.'. $img->getClientOriginalExtension();
                    $img_url = url('/uploads/images/slider/'. $img_name);
                    
                    $moved = $img->move($directory, $img_name);
                    $slider->image = $img_url;
                }
            }
            
            if($slider->save())
            {
                return redirect('home/slideshow')
                    ->with('msg','Slider has been saved');
            }
            else
            {
                return redirect()->back()
                    ->with('err','Slider cannot be saved');
            }
        }
    }
    
    
    /*
    * Delete
    */
    public function postDelete(Request $request)
    {
        $slider = Slideshow::find($request->input('id'));
        
        if($slider->delete())
        {
            return redirect()->back()
                ->with('msg','Slider has been deleted');
        }
        else
        {
            return redirect()->back()
                ->with('err','Slider cannot be deleted');
        }
        
    }

}
