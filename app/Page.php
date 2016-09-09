<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Page Model
 */
class Page extends Model
{

    protected $table = 'pages';
    protected $fillable = ['name','slug','description'];
}


?>
