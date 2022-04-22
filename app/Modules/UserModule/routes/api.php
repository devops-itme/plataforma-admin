<?php

use Illuminate\Support\Facades\Route;

//Auth
Route::post('login', 'UserModule\Controllers\Api\AuthController@Login');
Route::post('logout', 'UserModule\Controllers\Api\AuthController@signOut');
Route::post('forgotPassword', 'UserModule\Controllers\Api\AuthController@recovery');
Route::post('confirmCode', 'UserModule\Controllers\Api\AuthController@verifyCode');
Route::post('restorePassword', 'UserModule\Controllers\Api\AuthController@restore');
Route::post('resendCode', 'UserModule\Controllers\Api\AuthController@forward');
Route::post('customer/signIn', 'UserModule\Controllers\Api\AuthController@registerCustomer');
Route::get('sendPushNotification', 'UserModule\Controllers\UserController@sendPushNotification');