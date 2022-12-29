<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {

        Route::get('/ordenes/historial', 'OrderModule\Controllers\OrderController@record')->name('orders.record');
        Route::resource('/ordenes', 'OrderModule\Controllers\OrderController')->names('orders');
        Route::resource('/ordenes-internacionales', 'OrderModule\Controllers\InternationalOrderController')->names('internationalOrders');
        Route::post('/importBatch', 'OrderModule\Controllers\InternationalOrderController@importBatch')->name('internationalOrders.import');
        Route::post('/importBatch/add-guides/{order_id}', 'OrderModule\Controllers\InternationalOrderController@addGuidesToBatch')->name('internationalOrders.import.addGuides');
        Route::post('/exportBatch', 'OrderModule\Controllers\InternationalOrderController@exportBatch')->name('internationalOrders.export');
    });
    Route::get('/export_incidences', 'OrderModule\Controllers\InternationalOrderController@incidencesExport')->name('internationalOrders.incidencesExport');
    Route::get('getOrder/{id}', 'OrderModule\Controllers\OrderController@getOrder');
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

    Route::group(['middleware' => 'role'], function () {
    //PACKING
        Route::get('despachos-packing', 'OrderModule\Controllers\DeliveryController@indexPacking')->name('deliveryPacking.index');
    });

    //PACKING PICKUP TO DELIVERY
    Route::put('guide/estado/recogida-entrega', 'OrderModule\Controllers\DeliveryController@sendOrdersPickupToDelivery');



    //PICKUP POR DESPACHAR
    Route::put('guide/estado/recogida-pordespachar', 'OrderModule\Controllers\DeliveryController@changeStateGuidesPickupToByDispatch');

    //PICKUP DESPACHADA
    Route::put('guide/estado/recogida-despachada', 'OrderModule\Controllers\DeliveryController@changeStateGuidesPickupToDispatched');

     //PICKUP FINALIZADA -- RECOGIDA
     Route::put('guide/estado/recogida-finalizada', 'OrderModule\Controllers\DeliveryController@changeStateGuidesPickupToPicked');


     //DELIVERY POR DESPACHAR
    Route::put('guide/estado/entrega-pordespachar', 'OrderModule\Controllers\DeliveryController@changeStateGuidesDeliveryToByDispatch');

    //DELIVERY DESPACHADA
    Route::put('guide/estado/entrega-despachada', 'OrderModule\Controllers\DeliveryController@changeStateGuidesDeliveryToDispatched');

     //DELIVERY FINALIZADA -- ENTREGADA
     Route::put('guide/estado/entrega-finalizada', 'OrderModule\Controllers\DeliveryController@changeStateGuidesDeliveryToDelivered');



    //RUTAS SHOW GUIDE
    Route::group(['middleware' => 'role'], function () {
        Route::get('/details/{id}/show', 'OrderModule\Controllers\OrderController@showModGuide')->name('guides.show');
    });
});
