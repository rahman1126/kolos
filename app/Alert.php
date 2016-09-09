<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'msg_alert';
    protected $fillable = ['message','icon'];
}