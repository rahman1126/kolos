<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormMerchant extends Model
{
    protected $table = 'form_merchant';
    protected $fillable = array('business_name', 'category', 'business_address', 'business_phone', 'name', 'email', 'phone', 'description', 'profile_picture', 'open_time', 'close_time', 'area_covered', 'number_employees', 'services', 'email_registration', 'username' ,'password', 'mobile');
}
