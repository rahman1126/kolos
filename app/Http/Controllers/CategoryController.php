<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;

use Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function getIndex()
    {
    	$categories = Category::orderBy('id','DESC')->paginate(20)->setPath('category');
    	return view('admin.category.view')->with('categories', $categories);
    }

    public function getCreate()
    {
    	return view('admin.category.create');
    }

    // create process
    public function postStore(Request $request)
    {
    	$valid = Validator::make($request->all(), [
    		'name' => 'required|max:100',
    		'description' => 'required|max:255',
    		'cover' => 'image|max:2048|mimes:jpeg,gif,png',
    	]);

    	if ($valid->fails()) {
    		return redirect()->back()
    			->withInput()
    			->withErrors($valid);
    	} else {

    		$category = new Category;
    		$category->name = $request->input('name');
    		$category->description = $request->input('description');
    		$category->top = ($request->input('top') == '' ? false : true);

    		if ($request->hasFile('cover')) {
                $image = $request->file('cover');

                if ($request->file('cover')->isValid()) {
                    $directory = public_path() . '/uploads/images/category/';
                    $bg_name =  'bg_' . str_slug($category->name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/category/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $category->cover = $bg_url;

                }

            }

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                if ($request->file('logo')->isValid()) {
                    $directory = public_path() . '/uploads/images/category/';
                    $bg_name =  'logo_' . str_slug($category->name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/category/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $category->logo = $bg_url;
                }
            }

            if ($category->save()) {
    			return redirect('home/category')
    				->with('msg', $request->input('name') .' has been created');
    		} else {
    			return redirect()->back()
    				->withInput()
    				->with('err', 'oops, something went wrong. Please try again');
    		}

    	}
    }


    public function getEdit($id)
    {
    	$category = Category::find($id);
    	return view('admin.category.edit')->with('category', $category);
    }

    public function postUpdate(Request $request)
    {
    	$valid = Validator::make($request->all(), [
    		'name' => 'required|max:100',
    		'description' => 'required|max:255',
    		'cover' => 'image|max:2048|mimes:jpeg,gif,png',
    		'logo' => 'image|max:2048|mimes:jpeg,gif,png',
    	]);

    	if ($valid->fails()) {
    		return redirect()->back()
    			->withInput()
    			->withErrors($valid);
    	} else {

    		$category = Category::find($request->input('id'));
    		$category->name = $request->input('name');
    		$category->description = $request->input('description');
    		$category->top = ($request->input('top') == '' ? false : true);

    		if ($request->hasFile('cover')) {
                $image = $request->file('cover');

                if ($request->file('cover')->isValid()) {
                    $directory = public_path() . '/uploads/images/category/';
                    $bg_name =  'bg_' . str_slug($category->name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/category/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $category->cover = $bg_url;

                }

            }

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                if ($request->file('logo')->isValid()) {
                    $directory = public_path() . '/uploads/images/category/';
                    $bg_name =  'logo_' . str_slug($category->name, "_") .'.'. $image->getClientOriginalExtension();
                    $bg_url = url('/uploads/images/category/'. $bg_name);

                    $moved = $image->move($directory, $bg_name);
                    $category->logo = $bg_url;
                }
            }

            if ($category->save()) {
    			return redirect('home/category')
    				->with('msg', $request->input('name') .' has been updated');
    		} else {
    			return redirect()->back()
    				->withInput()
    				->with('err', 'oops, something went wrong. Please try again');
    		}

    	}
    }

    public function postSetastop(Request $request)
    {
    	$id = $request->input('id');
    	$category = Category::find($id);
    	$category->top = 1;
    	if ($category->save()) {
    		return redirect()->back()
    			->with('msg', $category->name. ' has been set to top');
    	} else {
    		return redirect()->back()
    			->with('err', $category->name. ' cannot be set to top');
    	}
    }

    public function postSetasuntop(Request $request)
    {
    	$id = $request->input('id');
    	$category = Category::find($id);
    	$category->top = 0;
    	if ($category->save()) {
    		return redirect()->back()
    			->with('msg', $category->name. ' has been set to untop');
    	} else {
    		return redirect()->back()
    			->with('err', $category->name. ' cannot be set to untop');
    	}
    }

    // activate
    public function postActivate(Request $request)
    {
        $id = $request->input('id');
        $category = Category::find($id);
        $category->active = 1;
        if ($category->save()) {
            return redirect()->back()
                ->with('msg', $category->name. ' has been set to active');
        } else {
            return redirect()->back()
                ->with('err', $category->name. ' cannot be set to active');
        }
    }

    public function postDeactivate(Request $request)
    {
        $id = $request->input('id');
        $category = Category::find($id);
        $category->active = 0;
        if ($category->save()) {
            return redirect()->back()
                ->with('msg', $category->name. ' has been deactivated');
        } else {
            return redirect()->back()
                ->with('err', $category->name. ' cannot be deactivated');
        }
    }

    public function postDelete(Request $request)
    {
    	$category = Category::find($request->input('id'));
    	if ($category->delete()) {
    		return redirect()->back()
    		->with('msg', 'Category has been deleted');
    	} else {
    		return redirect()->back()
    		->with('err', 'Category cannot be deleted');
    	}
    }
}
