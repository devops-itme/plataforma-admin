<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('rates', 'RateModule\Controllers\Api\RateController')->names('rates-api');
});
