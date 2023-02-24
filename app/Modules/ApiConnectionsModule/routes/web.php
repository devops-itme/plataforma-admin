<?php

use Illuminate\Support\Facades\Route;

Route::post('import-shipments', 'ApiConnectionsModule\Controllers\TealcaController@importShipments');

//Coordinadora
Route::get('/token', function () {return csrf_token(); });
Route::get('coordinadora/authenticate', 'ApiConnectionsModule\Controllers\CoordinadoraController@authenticate');
Route::post('coordinadora/generate-guides/{order_id}', 'ApiConnectionsModule\Controllers\CoordinadoraController@generateGuides')->name('coordinadora.send.batch');
Route::post('coordinadora/print-labels', 'ApiConnectionsModule\Controllers\CoordinadoraController@printLabels');
Route::post('coordinadora/schedule-pickup', 'ApiConnectionsModule\Controllers\CoordinadoraController@schedulePickup');
Route::get('coordinadora/pickup-tracking', 'ApiConnectionsModule\Controllers\CoordinadoraController@pickupTracking');
Route::get('coordinadora/get-methods', 'ApiConnectionsModule\Controllers\CoordinadoraController@getMethods');
Route::get('coordinadora/send/batch/{order_id}', 'ApiConnectionsModule\Controllers\CoordinadoraController@');

//Route::get('coordinadora/token', 'ApiConnectionsModule\Controllers\CoordinadoraController@token');


//Sincronizador
Route::get('sync/activity-logs', 'ApiConnectionsModule\Controllers\ApiSyncController@index')->name('sync.index');