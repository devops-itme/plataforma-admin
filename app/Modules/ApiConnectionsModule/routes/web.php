<?php

use Illuminate\Support\Facades\Route;

Route::post('import-shipments', 'ApiConnectionsModule\Controllers\TealcaController@importShipments');

//Coordinadora
Route::get('testConection', 'ApiConnectionsModule\Controllers\CoordinadoraController@testConnection');
Route::get('generateGuide', 'ApiConnectionsModule\Controllers\CoordinadoraController@generateGuide');
