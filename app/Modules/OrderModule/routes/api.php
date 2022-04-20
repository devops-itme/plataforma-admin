<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('order/markAsRead', 'OrderModule\Controllers\Api\OrderController@markAsRead');
    Route::resource('orders', 'OrderModule\Controllers\Api\OrderController')->names('order');
    Route::put('order/changeStatus', 'OrderModule\Controllers\Api\OrderController@changeStatus')->name('order.changeStatus');
});
