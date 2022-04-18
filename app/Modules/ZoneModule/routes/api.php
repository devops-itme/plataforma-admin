<?php

use Illuminate\Support\Facades\Route;

Route::get('getPlaces', 'ZoneModule\Controllers\Api\PlaceController@getPlaces');