<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMerchant;
use App\Service;
use App\Order;
use App\OrderService;
use App\Review;
use App\Feedback;
use App\Alert;

use Auth;
use Mail;
use Validator;

/* 
 * KOLOS API v2
 * -----------------
 */


class KolosApi extends Controller
{
    
    // ************* Category *************
    public function get_categories()
    {
        
    }
    
    public function get_top_categories()
    {
        
    }
    
    public function get_detail_category()
    {
        
    }
    
    // ****************  Merchant ****************
    public function get_merchants()
    {
        
    }
    
    public function get_detail_merchant()
    {
        
    }
    
    public function get_top_merchants()
    {
        
    }
    
    public function get_favorite_merchants()
    {
        
    }
    
    public function post_add_favorite_merchant()
    {
        
    }
    
    public function post_remove_favorite_merchant()
    {
        
    }
    
    // **************** Order ******************
    public function post_create_order()
    {
        
    }
    
    public function get_orders()
    {
        
    }
    
    public function get_pro_orders()
    {
        
    }
    
    public function get_detail_order()
    {
        
    }
    
    public function get_total_order()
    {
        
    }
    
    public function get_total_pro_order()
    {
        
    }
    
    public function post_accept_order()
    {
        
    }
    
    public function post_decline_order()
    {
        
    }
    
    public function post_cancel_order()
    {
        
    }
    
    public function post_complete_order()
    {
        
    }
    
    // ************** Review & Feedback **************
    public function post_create_review()
    {
        
    }
    
    public function post_create_feedback()
    {
        
    }
    
    public function get_check_review()
    {
        
    }
    
    
    // *************** Homeslideshow **************
    public function get_slideshows()
    {
        
    }
    
    // *************** 
    
}
