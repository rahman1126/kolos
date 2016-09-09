<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Page;

/**
 * Web Controller
 */
class WebController extends Controller
{

    public function getPage($params)
    {
        $page = Page::where('slug', $params)->first();
        return view('page')->with('page', $page);
    }
}


?>
