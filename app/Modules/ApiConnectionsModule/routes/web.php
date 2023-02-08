<?php

use Illuminate\Support\Facades\Route;

Route::post('import-shipments', 'ApiConnectionsModule\Controllers\TealcaController@importShipments');

//Coordinadora
Route::post('coordinadora/generate-guide', 'ApiConnectionsModule\Controllers\CoordinadoraController@generateGuide');
Route::post('coordinadora/print-labels', 'ApiConnectionsModule\Controllers\CoordinadoraController@printLabels');
Route::post('coordinadora/schedule-pickup', 'ApiConnectionsModule\Controllers\CoordinadoraController@schedulePickup');
Route::get('coordinadora/pickup-tracking', 'ApiConnectionsModule\Controllers\CoordinadoraController@pickupTracking');
Route::get('coordinadora/get-methods', 'ApiConnectionsModule\Controllers\CoordinadoraController@getMethods');
//Route::get('coordinadora/token', 'ApiConnectionsModule\Controllers\CoordinadoraController@token');


//Sincronizador
Route::get('sync/activity-logs', 'ApiConnectionsModule\Controllers\ApiSyncController@index')->name('sync.index');