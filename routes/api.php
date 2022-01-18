<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('api', function (Request $request) {
//     Route::get('/register', 'PassportController@register');
// });


Route::middleware('localization')->group(function () {
    Route::post('login', 'Api\ClientController@login');
    Route::post('register', 'Api\ClientController@register');
    Route::get('center', 'Api\AppController@center');
    Route::get('terms_and_conditions', 'Api\AppController@TermsAndConditions');
    Route::post('contact_email', 'Api\AppController@contactMail');
    Route::get('countries', 'Api\AppController@countries');
    Route::get('sliders', 'Api\AppController@sliders');
    Route::get('banks', 'Api\BankController@index');
    Route::get('search/{key}', 'Api\AppController@search');

    //-------------------------------------------------------
    Route::get('services', 'Api\ServiceController@index');
    Route::get('services/free', 'Api\ServiceController@freeServices');
    Route::get('services/additional', 'Api\ServiceController@additionalServices');

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', 'Api\ClientController@profile');
        Route::post('profile/update', 'Api\ClientController@UpdateProfile');
        Route::post('profile/update/image', 'Api\ClientController@updateProfileImage');
        Route::post('profile/update_password', 'Api\ClientController@updatePassword');
        Route::post('logout', 'Api\ClientController@logout');
        Route::get('notifications', 'Api\NotificationController@index');
        Route::post('notification/delete', 'Api\NotificationController@delete');
    });
});
