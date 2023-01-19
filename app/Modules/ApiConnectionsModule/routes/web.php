<?php

use Illuminate\Support\Facades\Route;

Route::post('import-shipments', 'ApiConnectionsModule\Controllers\TealcaController@importShipments');

//Coordinadora
Route::get('testConection', 'ApiConnectionsModule\Controllers\CoordinadoraController@testConnection');
Route::get('generateGuide', 'ApiConnectionsModule\Controllers\CoordinadoraController@generateGuide');
Route::get('coordinadora/create-order', 'ApiConnectionsModule\Controllers\CoordinadoraController@createOrderRequest');
Route::get('coordinadora/login', 'ApiConnectionsModule\Controllers\CoordinadoraController@login');

//Sincronizador
Route::get('sync/activity-logs', 'ApiConnectionsModule\Controllers\ApiSyncController@index')->name('sync.index');