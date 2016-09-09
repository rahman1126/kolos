<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Slideshow;

class SlideshowUccul extends Controller
{
    public function getSlideshows()
    {
        $slides = Slideshow::all();
        if($slides->isEmpty())
        {
            return response()->json([
                'status'    => 201,
                'data'      => 'No slides found.',
            ]);
        }
        else
        {
            return response()->json([
                'status'    => 200,
                'data'      => $slides,
            ]);
        }
    }
}
