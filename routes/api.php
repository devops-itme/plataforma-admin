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
Route::post('login', 'Api\AuthController@SignIn');
Route::post('logout', 'Api\AuthController@signOut');
Route::post('forgotPassword', 'Api\AuthController@recovery');
Route::post('confirmCode', 'Api\AuthController@verifyCode');
Route::post('restorePassword', 'Api\AuthController@restore');
Route::post('resendCode', 'Api\AuthController@forward');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('messenger/show', 'Api\MessengerController@show')->name('messenger.show');
    Route::put('messenger/update', 'Api\MessengerController@update')->name('messenger.update');

    Route::resource('orders', 'Api\OrderController')->names('order');
    Route::resource('guides', 'Api\GuideController')->names('guides');
});
