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
//Auth
Route::post('login', 'Api\AuthController@Login');
Route::post('logout', 'Api\AuthController@signOut');
Route::post('forgotPassword', 'Api\AuthController@recovery');
Route::post('confirmCode', 'Api\AuthController@verifyCode');
Route::post('restorePassword', 'Api\AuthController@restore');
Route::post('resendCode', 'Api\AuthController@forward');
Route::post('customer/signIn', 'Api\AuthController@registerCustomer');

//Parameter values
Route::get('parameter_values', 'Api\ParameterValueController@getParameterValues');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('customer/show', 'Api\CustomerController@show')->name('customer.show');
    Route::put('customer/update', 'Api\CustomerController@update')->name('customer.update');

    Route::get('address', 'Api\AddressController@index')->name('address');
    Route::post('address/store', 'Api\AddressController@store')->name('address.store');
    Route::put('address/update/{id}', 'Api\AddressController@update')->name('address.update');
    Route::delete('address/{id}', 'Api\AddressController@destroy')->name('address.delete');

    Route::get('messenger/show', 'Api\MessengerController@show')->name('messenger.show');
    Route::put('messenger/update', 'Api\MessengerController@update')->name('messenger.update');

    Route::post('order/markAsRead', 'Api\OrderController@markAsRead');
    Route::resource('orders', 'Api\OrderController')->names('order');

    Route::post('guide/update-additional-information', 'Api\GuideController@updateAdditionalInformation');
    Route::post('guide/markAsRead', 'Api\GuideController@markAsRead');
    Route::resource('guides', 'Api\GuideController')->names('guides');
    Route::put('guide/changeStatus', 'Api\GuideController@changeStatus')->name('guide.changeStatus');

    Route::resource('hours', 'Api\PickupHourController')->names('hours');
});
