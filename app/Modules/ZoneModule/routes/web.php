<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('getPlaces', 'ZoneModule\Controllers\PlaceController@getPlaces');
    Route::get('getZoneNeighborhoods/{id}', 'ZoneModule\Controllers\PlaceController@getZoneNeighborhoods');
    Route::group(['middleware' => 'role'], function () {
    Route::resource('zonas', 'ZoneModule\Controllers\ZoneController')->names('zones');
     });
});
