<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorite_user';
    protected $fillable = array('user_id', 'merchant_id');
    public $timestamps = false;
}
