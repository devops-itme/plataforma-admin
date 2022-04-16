<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        Route::resource('direcciones', 'AddressModule\Controllers\AddressController')->names('addresses');
    });
    Route::get('/customer_addresses/{id}', 'AddressModule\Controllers\AddressController@customerAddresses');
});
