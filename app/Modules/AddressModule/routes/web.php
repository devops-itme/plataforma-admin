<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        Route::resource('direcciones', 'AddressModule\Controllers\AddressController')->names('addresses');
    });
});
