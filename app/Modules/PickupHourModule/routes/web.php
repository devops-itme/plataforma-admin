<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('horas', 'PickupHourModule\Controllers\PickupHourController')->except('delete')->names('hours');
    Route::delete('horas/{id}', 'PickupHourModule\Controllers\PickupHourController@destroy')->name('hours.delete');
    Route::get('/getPickupHours', 'PickupHourModule\Controllers\PickupHourController@pickupHours');
});
