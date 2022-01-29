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
    Route::get('olic', 'Api\AppController@olic');
    Route::get('terms_and_conditions', 'Api\AppController@TermsAndConditions');
    Route::post('contact_email', 'Api\AppController@contactMail');
    Route::get('countries', 'Api\AppController@countries');
    Route::get('sliders', 'Api\AppController@sliders');
    Route::get('banks', 'Api\BankController@index');
    Route::get('search/{key}', 'Api\AppController@search');
    Route::get('common_questions', 'Api\AppController@commonQuestions');

    //-------------------------------------------------------
    Route::get('services', 'Api\ServiceController@index');
    Route::get('services/free', 'Api\ServiceController@freeServices');
    Route::get('services/additional', 'Api\ServiceController@additionalServices');
    Route::get('cars/brands', 'Api\CarController@carsBrands');
    Route::get('cars/models/{brand_id}', 'Api\CarController@carsModels');
    Route::get('cars/cylinders', 'Api\CarController@carsCylinders');
    Route::post('day_appointments', 'Api\AppointmentController@dayAppointments');
    Route::get('oil/types', 'Api\OilController@oilTypes');
    Route::get('oils/{type_id}/type', 'Api\OilController@oils');
    Route::post('services/check_location', 'Api\ServiceController@checkLocation');
    Route::post('coupon/apply', 'Api\ServiceController@applyCoupon');

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', 'Api\ClientController@profile');
        Route::post('profile/update', 'Api\ClientController@UpdateProfile');
        Route::post('profile/update/image', 'Api\ClientController@updateProfileImage');
        Route::post('profile/update_password', 'Api\ClientController@updatePassword');
        Route::post('logout', 'Api\ClientController@logout');
        Route::get('notifications', 'Api\NotificationController@index');
        Route::post('notification/delete', 'Api\NotificationController@delete');
        Route::post('client/cars', 'Api\CarController@clientCars');
        Route::post('client/cars/add', 'Api\CarController@createClientCars');
        Route::post('reservation/make', 'Api\ReservationController@makeReservation');
        Route::get('client/reservations', 'Api\ReservationController@clientReservations');
    });
});
