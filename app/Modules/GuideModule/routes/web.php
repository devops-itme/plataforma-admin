<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
    Route::resource('/guias', 'GuideModule\Controllers\GuideController')->names('guides');
});

    Route::get('/coordinadora/order/detail/{order_id}', 'GuideModule\Controllers\ShipmentController@coordinadoraGuideDetails')->name('coordinadora.shipments.show.detail');
    Route::get('/coordinadora/create/{order_id}', 'GuideModule\Controllers\ShipmentController@coordinadoraCreateGuideView')->name('coordinadora.create');
    Route::post('/coordinadora/guide/store', 'GuideModule\Controllers\ShipmentController@coordinadoraAddGuide')->name('coordinadora.store.guide');
    Route::get('/coordinadora/guide/edit/{id}', 'GuideModule\Controllers\ShipmentController@coordinadoraEditGuide')->name('coordinadora.edit');
    Route::put('/coordinadora/guide/update/{id}', 'GuideModule\Controllers\ShipmentController@coordinadoraUpdateGuide')->name('coordinadora.update.guide');
    Route::delete('/coordinadora/delete/{id}', 'GuideModule\Controllers\ShipmentController@coordinadoraDeleteGuide')->name('coordinadora.delete.guide');
    Route::delete('/coordinadora/delete/product/{id}', 'GuideModule\Controllers\ShipmentController@coordinadoraDeleteProduct')->name('coordinadora.delete.product');


    Route::post('validateGuide', 'GuideModule\Controllers\GuideController@validateGuide');
    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'GuideModule\Controllers\GuideController@guidesForDeliveryPacking');

    Route::post('pordespachar/packaging/{id}', 'GuideModule\Controllers\GuideController@porDespacharPackaging');

    Route::post('guias/import', 'GuideModule\Controllers\GuideController@importGuide')->name('guide.import');

    Route::put('guide/update', 'GuideModule\Controllers\GuideController@updatePackingGuide');
    Route::put('guide/update/issue', 'GuideModule\Controllers\GuideController@updateGuideLog');
    /** **/
    //Route::post('/sendBatch/{id}', 'GuideModule\Controllers\ShipmentController@sendBatch')->name('shipments.assign');
});

//Tealca Deliverys
Route::group(['middleware' => 'role'], function () {
Route::resource('/envios-internacionales', 'GuideModule\Controllers\ShipmentController')->names('shipments');
Route::get('/editar/{id}/edit', 'GuideModule\Controllers\ShipmentController@edit')->name('shipments.edit');
Route::get('/mostrar/{id}/show', 'GuideModule\Controllers\ShipmentController@show')->name('shipments.show');
Route::put('/update/{id}', 'GuideModule\Controllers\ShipmentController@update')->name('shipments.update');
Route::post('/sendBatch/{id}', 'GuideModule\Controllers\ShipmentController@sendBatch')->name('shipments.assign');

});
