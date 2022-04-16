<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('hours', 'PickupHourModule\Controllers\Api\PickupHourController')->names('hours');
});
