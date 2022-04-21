<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/guias', 'GuideModule\Controllers\GuideController')->names('guias')->except('store');
    Route::post('/guias/store', 'GuideModule\Controllers\GuideController@store')->name('guide.store');

    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'GuideModule\Controllers\GuideController@guidesForDeliveryPacking');

    Route::post('pordespachar/packaging/{id}', 'GuideModule\Controllers\GuideController@porDespacharPackaging');

    Route::post('guias/import', 'GuideModule\Controllers\GuideController@importGuide')->name('guide.import');

    Route::put('guide/update', 'GuideModule\Controllers\GuideController@updatePackingGuide');
});
