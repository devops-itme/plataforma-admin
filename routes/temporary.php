<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {

        Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');

        //CUSTOMER
        Route::resource('/clientes', 'CustomerModule\Controllers\CustomerController')->except('store')->names('customers');
        Route::post('/clientes/store', 'CustomerModule\Controllers\CustomerController@store')->name('customers.store');
    });
<<<<<<< HEAD
=======
    Route::resource('zonas', 'ZoneModule\Controllers\ZoneController')->names('zones');
    Route::get('getPlaces', 'ZoneModule\Controllers\PlaceController@getPlaces');
    Route::get('getZoneNeighborhoods/{id}', 'ZoneModule\Controllers\PlaceController@getZoneNeighborhoods');
>>>>>>> b427a1a0e203290e833e76cf944c1c7de0974ee6
});
