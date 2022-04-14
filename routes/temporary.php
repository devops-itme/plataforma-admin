<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {

        Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');
        Route::resource('mensajeros', 'MessengerModule\Controllers\MessengerController')->names('messengers');
    });
    Route::resource('zonas', 'ZoneModule\Controllers\ZoneController')->names('zones');
    Route::get('getPlaces', 'ZoneModule\Controllers\PlaceController@getPlaces');
    Route::get('getZoneNeighborhoods/{id}', 'ZoneModule\Controllers\PlaceController@getZoneNeighborhoods');
});
