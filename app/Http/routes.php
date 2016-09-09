<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/', function () {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	    //return view('welcome');
        return Redirect::to('lang/id');
	});
    Route::get('/lang/{locale}', function ($locale) {
        App::setLocale($locale);
        return view('welcome');
    });
    Route::get('/page/{slug}', 'WebController@getPage');

    Route::controller('register/pro', 'ProController');

    Route::post('submit/form/merchant', 'FormController@submit');
    Route::get('home', 'HomeController@index');
    Route::get('home/view/profile/{id}', 'HomeController@getViewProfile');
    Route::get('home/view/company/{id}', 'HomeController@getViewCompany');
    Route::get('home/becomepro', 'HomeController@getBecomePro');
    Route::post('home/becomeprorequest', 'HomeController@postBecomePro');
    Route::get('home/profile', 'HomeController@getProfile');
    Route::get('home/profile/company', 'HomeController@getMerchantprofile');
    Route::post('home/profile/update', 'HomeController@postProfile');
    Route::post('home/profile/merchant/update', 'HomeController@postMerchant');
    Route::controller('home/order', 'OrderController');
    Route::controller('home/service', 'ServiceController');
    Route::controller('home/follower', 'FollowerController');

});

Route::group(['middleware' => ['web','csrf','admin']], function () {
    Route::controller('home/user', 'UserController');
    Route::controller('home/page', 'PageController');
    Route::controller('home/category', 'CategoryController');
    Route::controller('home/form', 'FormController');
    Route::controller('home/slideshow', 'SlideshowController');
    Route::controller('home/notification', 'NotificationController');
});

/**
 * API without protection
 */
Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'],
function () {

    Route::post('register', 'Api\AuthUccul@register');
    Route::post('login', 'Api\AuthUccul@login');
    Route::post('login/facebook', 'Api\AuthUccul@facebook');
    Route::post('login/google', 'Api\AuthUccul@facebook');

    Route::get('merchant/all', 'Api\MerchantUccul@getAll');
    Route::get('merchant/detail', 'Api\MerchantUccul@getDetail');
    Route::get('merchant/featured', 'Api\MerchantUccul@getFeatured');

    Route::get('category/all', 'Api\CategoryUccul@getAll');
    Route::get('category/top', 'Api\CategoryUccul@getTop');
    Route::get('category/detail', 'Api\CategoryUccul@getDetail');

    // homeslideshow
    Route::get('slideshow/all', 'Api\SlideshowUccul@getSlideshows');

    // search
    Route::get('search', 'Api\MerchantUccul@getSearch');

});

Route::group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'],
function () {

    Route::post('gcm', 'Api\AuthUccul@gcm');
    Route::post('request/pro', 'Api\MerchantUccul@postRequest');
    //Route::post('getuser', 'Api\AuthUccul@getUser');

    Route::get('review/check', 'Api\ReviewUccul@getLastreview');

    Route::post('notification/push', 'Api\NotificationUccul@push');

    Route::get('alert/get', 'Api\AlertUccul@getAlerts');
    Route::get('alert/getnum', 'Api\AlertUccul@getAlertNum');
    Route::post('alert/read', 'Api\AlertUccul@postRead');

    Route::get('merchant/favorites', 'Api\MerchantUccul@getFavorites'); // need auth.basic
    Route::post('merchant/addToFavorite', 'Api\MerchantUccul@addFavorite'); // need auth.basic
    Route::post('merchant/removeFromFavorite', 'Api\MerchantUccul@removeFavorite'); // need auth.basic

    Route::post('order/create', 'Api\OrderUccul@create');
    Route::get('order/view', 'Api\OrderUccul@view');
    Route::get('order/view/pro', 'Api\OrderUccul@viewpro');
    Route::get('order/detail', 'Api\OrderUccul@detail');
    Route::get('order/pro/num', 'Api\OrderUccul@orderpronum');
    Route::get('order/num', 'Api\OrderUccul@ordernum');

    Route::post('order/accept', 'Api\OrderUccul@accept');
    Route::post('order/complete', 'Api\OrderUccul@complete');
    Route::post('order/decline', 'Api\OrderUccul@decline');
    Route::post('order/cancel', 'Api\OrderUccul@cancel');



    Route::get('review/get', 'Api\ReviewUccul@getReviews');
    Route::post('review/create', 'Api\ReviewUccul@postReview');
    Route::post('feedback/create', 'Api\ReviewUccul@postFeedback');

    Route::post('user/edit', 'Api\AuthUccul@edit');
});



/**
 * API without protection
 */
Route::group(['prefix' => 'api/v2', 'middleware' => 'cors'],
function () {

    Route::post('auth/register', 'App\AuthCtrl@register');
    Route::post('authenticate', 'App\AuthCtrl@authenticate');
    Route::get('authenticate/user', 'App\AuthCtrl@getAuthenticatedUser');

    Route::post('alert/checkalert', 'App\OrderCtrl@getNewRecord'); //<-- demo
    Route::post('alert/getrecord', 'App\OrderCtrl@getLatestRecord'); //<-- demo
    Route::post('alert/getlastalert', 'App\OrderCtrl@getLatestAlert'); //<-- demo
    Route::post('alert/read', 'Api\AlertUccul@postRead'); //<-- demo
    Route::post('alert/sendemail', 'App\OrderCtrl@sendEmailNewOrder'); //<-- demo

    Route::get('merchant/detail', 'App\MerchantCtrl@detailMerchant');
});

Route::group(['prefix' => 'api/v2', 'middleware' => ['jwt.auth','cors']],
function() {
    Route::get('order/list', 'App\OrderCtrl@listOrder');
    Route::get('order/detail', 'App\OrderCtrl@detailOrder');

    Route::get('profile/get', 'App\UserCtrl@profile');
    Route::post('profile/edit', 'App\UserCtrl@profileEdit');
    Route::post('order/create', 'App\OrderCtrl@create');

    Route::post('profile/upload', 'App\UserCtrl@upload'); // move this to protected routes
    // Route::post('profile/upload', 'App\UserCtrl@upload');
});
