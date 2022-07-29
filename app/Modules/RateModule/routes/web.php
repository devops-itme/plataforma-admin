<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    // Route::group(['middleware' => 'role'], function () {
        Route::resource('tarifas', 'RateModule\Controllers\RateController')->names('rates');
        Route::post('tarifas/import', 'RateModule\Controllers\RateController@importRate')->name('rates.import');
    // });
});
