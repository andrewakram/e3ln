<?php

use Illuminate\Http\Request;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/user'], function () {
    //Start apis authentication
    Route::post('/register', 'Api\User\AuthController@register');
    Route::post('/be_a_shop', 'Api\User\AuthController@beAShop');
    Route::post('/code_send', 'Api\User\AuthController@codeSend');
    Route::post('/code_check', 'Api\User\AuthController@codeCheck');
    Route::post('/login', 'Api\User\AuthController@login');
    Route::post('/forget_password', 'Api\User\AuthController@forgetPassword');
    Route::post('/update_profile', 'Api\User\AuthController@updateProfile');
    //End apis authentication


    //Start apis HomeController
    Route::get('/countries', 'Api\User\HomeController@countries');
    Route::get('/govs_and_cities', 'Api\User\HomeController@govsAndCities');
    Route::get('/category', 'Api\User\HomeController@category');
    Route::get('/shops_category', 'Api\User\HomeController@shopsOfCategory');
    Route::get('/shops_details', 'Api\User\HomeController@shopDetails');
    Route::get('/offer_details', 'Api\User\HomeController@offerDetails');
    Route::post('/follow', 'Api\User\HomeController@followAndUnfollow');
    Route::post('/block', 'Api\User\HomeController@blockAndUnblock');
    Route::get('/reviews_details', 'Api\User\HomeController@getReviews');
    Route::post('/add_review', 'Api\User\HomeController@addReview');
    Route::get('/delete_review', 'Api\User\HomeController@deleteReview');
    //
    Route::get('/following_list', 'Api\User\HomeController@followingList');
    Route::get('/blocking_list', 'Api\User\HomeController@blockingList');
    //
    Route::post('/add_offer', 'Api\User\HomeController@addOffer');
    Route::post('/edit_offer', 'Api\User\HomeController@editOffer');
    Route::get('/delete_offer', 'Api\User\HomeController@deleteOffer');
    //
    Route::get('/phone_list', 'Api\User\HomeController@phoneList');
    Route::get('/delete_phone', 'Api\User\HomeController@deletePhone');
    Route::post('/add_phone', 'Api\User\HomeController@addPhone');
    //
    Route::get('/filter_data', 'Api\User\HomeController@filterMinMaxPrices');
    Route::get('/search', 'Api\User\HomeController@search');
    Route::get('/searchByName', 'Api\User\HomeController@searchByName');
    //
    Route::get('/about_us', 'Api\User\HomeController@aboutUs');
    Route::get('/terms', 'Api\User\HomeController@terms');
    Route::get('/notifications', 'Api\User\HomeController@notifications');
});

Route::get('/55',function (){
    $startTime = Carbon::parse('13:30');
    $finishTime = Carbon::parse('23:30');

    $totalDuration = $finishTime->diffInSeconds($startTime);
    $x = (int)gmdate('H', $totalDuration);
    return $x."H" ;

});

