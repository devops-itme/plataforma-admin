<?php

use Illuminate\Support\Facades\Route;

Route::post('import-shipments', 'ApiConnectionsModule\Controllers\TealcaController@importShipments');