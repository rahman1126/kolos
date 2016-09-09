<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProRequest extends Model
{
    protected $table = 'pro_request';
    protected $fillable = ['name','email','phone'];
}
