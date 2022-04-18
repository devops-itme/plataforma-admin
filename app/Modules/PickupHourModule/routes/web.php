<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('horas', 'PickupHourModule\Controllers\PickupHourController')->names('hours');
    Route::get('/getPickupHours', 'PickupHourModule\Controllers\PickupHourController@pickupHours');
});
