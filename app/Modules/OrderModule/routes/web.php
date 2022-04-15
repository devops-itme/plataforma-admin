<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
     
        Route::get('/ordenes/historial', 'OrderModule\Controllers\OrderController@record')->name('orders.record');
        Route::resource('/ordenes', 'OrderModule\Controllers\OrderController')->names('orders');
     
    });
    Route::get('orders_ondemand/{type}', 'OrderModule\Controllers\OrderController@ordersForDelivery');
    Route::get('/order_number', 'OrderModule\Controllers\OrderController@orderNumber');
    Route::post('pordespachar/ondemand/{id}', 'OrderModule\Controllers\OrderController@porDespacharOndemand');
});
