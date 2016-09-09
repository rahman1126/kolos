<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use App\User;
use App\UserMerchant;

class CategoryUccul extends Controller
{
    public function getAll()
    {
    	$categories = Category::all();
    	return response()->json(array(
    		'data' => $categories,
    		'status' => 200,
    	));
    }

    public function getTop()
    {
    	$categories = Category::getTop();
    	return response()->json(array(
    		'data' => $categories,
    		'status' => 200,
    	));
    }

    public function getDetail(Request $request)
    {
        $id = $request->input('id');
        $users = UserMerchant::where('active', 1)
            ->where('category_id', $id)
            ->get();
        if($users->isEmpty())
        {
            return response()->json(array(
                'status' => 201,
                'users' => 'No merchant found.',
            ));
        }
        else
        {
            return response()->json(array(
                'status' => 200,
                'users' => $users,
            ));
        }
    }
}
