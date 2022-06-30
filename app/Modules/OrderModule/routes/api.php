<?php

use Illuminate\Support\Facades\Route;
//NATIONAL ORDER
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('order/markAsRead', 'OrderModule\Controllers\Api\OrderController@markAsRead');
    Route::resource('orders', 'OrderModule\Controllers\Api\OrderController')->names('order');
    Route::put('order/finishOrder', 'OrderModule\Controllers\Api\OrderController@finishOrder')->name('order.finishOrder');
    Route::put('order/changeStatus', 'OrderModule\Controllers\Api\OrderController@changeStatus')->name('order.changeStatus');

    Route::get('order/webview/paguelo-facil', 'OrderModule\Controllers\Api\OrderController@webviewPagueloFacil')->name('order.webview');
});
Route::get('order/webview/paguelo-facil/response', 'OrderModule\Controllers\Api\OrderController@responseViewPagueloFacil')->name('order.webview.response');
Route::get('sendPushNotification', 'OrderModule\Controllers\Api\OrderController@sendPushNotification')->name('order.sendPushNotification');


//INTERNATIONAL ORDER
Route::middleware(['auth:sanctum'])->group(function () {
    // Route::resource('internationalOrders', 'OrderModule\Controllers\Api\InternationalOrderController')->names('internationalOrder');
    Route::get('internationalOrder/index', 'OrderModule\Controllers\Api\InternationalOrderController@index')->name('internationalOrder.index');
    Route::post('internationalOrder/create', 'OrderModule\Controllers\Api\InternationalOrderController@store')->name('internationalOrder.create');
});


