<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = array('name','description','cover','logo');

    public static function getTop()
    {
    	return Category::where('top', 1)->get();
    }
}
