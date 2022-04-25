<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('rates', 'RateModule\Controllers\Api\RateController')->names('rates-api');
});
Route::get('rateInquiry', 'RateModule\Controllers\Api\RateController@rateInquiry')->name('rateInquiry');
Route::get('calculatePackingRates', 'RateModule\Controllers\Api\RateController@calculatePackingRates')->name('calculatePackingRates');
