<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
     
        Route::get('/ordenes/historial', 'OrderModule\Controllers\OrderController@record')->name('orders.record');
        Route::resource('/ordenes', 'OrderModule\Controllers\OrderController')->names('orders');
        Route::resource('/ordenes-internacionales', 'OrderModule\Controllers\InternationalOrderController')->names('internationalOrders');
        Route::post('/importBatch', 'OrderModule\Controllers\InternationalOrderController@importBatch')->name('internationalOrders.import');
    });
    Route::post('/sendBatch/{id}', 'OrderModule\Controllers\InternationalOrderController@sendBatch')->name('internationalOrders.assign');
    Route::get('orders_ondemand/{type}', 'OrderModule\Controllers\OrderController@ordersForDelivery');
    Route::get('/order_number', 'OrderModule\Controllers\OrderController@orderNumber');
    Route::post('pordespachar/ondemand/{id}', 'OrderModule\Controllers\OrderController@porDespacharOndemand');


    //DELIVERY - DISPATCH
    
    //status matrix
    Route::get('despacho/matriz_estados', 'OrderModule\Controllers\DeliveryController@statusMatrix');


    Route::get('order_states', 'OrderModule\Controllers\DeliveryController@orderStates');
    Route::post('/ordenes/asignacion', 'OrderModule\Controllers\DeliveryController@assignOndemad')->name('orders.assign');
    Route::post('/quias/asignacion', 'OrderModule\Controllers\DeliveryController@assignPacking')->name('guides.assign');
    Route::post('/despacho/orden/estado', 'OrderModule\Controllers\DeliveryController@updateStateOrders');

    //ONDEMAND
    Route::get('despachos', 'OrderModule\Controllers\DeliveryController@indexOndemand')->name('delivery.index');

    //PACKING
    Route::get('despachos-packing', 'OrderModule\Controllers\DeliveryController@indexPacking')->name('deliveryPacking.index');
});

