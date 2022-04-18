<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('customer/show', 'CustomerModule\Controllers\Api\CustomerController@show')->name('customer.show');
    Route::put('customer/update', 'CustomerModule\Controllers\Api\CustomerController@update')->name('customer.update');
});
