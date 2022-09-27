<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
    Route::resource('/guias', 'GuideModule\Controllers\GuideController')->names('guides');
});
    Route::post('validateGuide', 'GuideModule\Controllers\GuideController@validateGuide');
    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'GuideModule\Controllers\GuideController@guidesForDeliveryPacking');

    Route::post('pordespachar/packaging/{id}', 'GuideModule\Controllers\GuideController@porDespacharPackaging');

    Route::post('guias/import', 'GuideModule\Controllers\GuideController@importGuide')->name('guide.import');

    Route::put('guide/update', 'GuideModule\Controllers\GuideController@updatePackingGuide');
    Route::put('guide/update/issue', 'GuideModule\Controllers\GuideController@updateGuideLog');
});

//Tealca Deliverys
Route::group(['middleware' => 'role'], function () {
Route::resource('/envíos-tealca', 'GuideModule\Controllers\ShipmentController')->names('shipments');
Route::get('/editar/{id}/edit', 'GuideModule\Controllers\ShipmentController@edit')->name('shipments.edit');
Route::get('/mostrar/{id}/show', 'GuideModule\Controllers\ShipmentController@show')->name('shipments.show');
Route::put('/update/{id}', 'GuideModule\Controllers\ShipmentController@update')->name('shipments.update');
Route::post('/sendBatch/{id}', 'GuideModule\Controllers\ShipmentController@sendBatch')->name('shipments.assign');
});
