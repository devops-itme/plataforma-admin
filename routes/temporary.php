<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {

        Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');

        //CUSTOMER
        Route::resource('/clientes', 'CustomerModule\Controllers\CustomerController')->except('store')->names('customers');
        Route::post('/clientes/store', 'CustomerModule\Controllers\CustomerController@store')->name('customers.store');

        //MESSENGERS
        Route::resource('mensajeros', 'MessengerModule\Controllers\MessengerController')->names('messengers');

        //DEPARTMENT
        Route::resource('departamentos', 'DepartmentModule\Controllers\DepartmentController')->names('departments');

    });
    Route::resource('zonas', 'ZoneModule\Controllers\ZoneController')->names('zones');
    Route::get('getPlaces', 'ZoneModule\Controllers\PlaceController@getPlaces');
    Route::get('getZoneNeighborhoods/{id}', 'ZoneModule\Controllers\PlaceController@getZoneNeighborhoods');
});
