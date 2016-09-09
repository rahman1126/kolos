<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    
    public function district()
    {
        return $this->belongsTo('App\City');
    }
}
