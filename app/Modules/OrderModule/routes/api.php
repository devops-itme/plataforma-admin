<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('order/markAsRead', 'OrderModule\Controllers\Api\OrderController@markAsRead');
    Route::resource('orders', 'OrderModule\Controllers\Api\OrderController')->names('order');
    Route::put('order/finishOrder', 'OrderModule\Controllers\Api\OrderController@finishOrder')->name('order.finishOrder');
    Route::put('order/changeStatus', 'OrderModule\Controllers\Api\OrderController@changeStatus')->name('order.changeStatus');

});
Route::post('order/webview/paguelofacil', 'OrderModule\Controllers\Api\OrderController@webviewPaguelofacil')->name('order.webview');
Route::get('order/webview/paguelofacil/response', 'OrderModule\Controllers\Api\OrderController@responseViewPaguelofacil')->name('order.webview.response');
