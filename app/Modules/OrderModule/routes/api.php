<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('order/markAsRead', 'OrderModule\Controllers\Api\OrderController@markAsRead');
    Route::resource('orders', 'OrderModule\Controllers\Api\OrderController')->names('order');
    Route::put('order/finishOrder', 'OrderModule\Controllers\Api\OrderController@finishOrder')->name('order.finishOrder');
    Route::put('order/changeStatus', 'OrderModule\Controllers\Api\OrderController@changeStatus')->name('order.changeStatus');

    Route::get('order/webview/paguelo-facil', 'OrderModule\Controllers\Api\OrderController@webviewPagueloFacil')->name('order.webview');
    Route::get('order/webview/paguelo-facil/response', 'OrderModule\Controllers\Api\OrderController@responseViewPagueloFacil')->name('order.webview.response');
});
