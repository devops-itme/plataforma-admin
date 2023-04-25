<?php

use Illuminate\Support\Facades\Route;

Route::post('import-shipments', 'ApiConnectionsModule\Controllers\TealcaController@importShipments');
Route::post('coordinadora/send/guides/{order_id}', 'ApiConnectionsModule\Controllers\CoordinadoraController@generateGuides');