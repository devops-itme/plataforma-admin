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
Route::post('login', 'Api\LoginController@SignIn');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('messenger/show', 'Api\MessengerController@show')->name('messenger.show');
    Route::put('messenger/update', 'Api\MessengerController@update')->name('messenger.update');
});
