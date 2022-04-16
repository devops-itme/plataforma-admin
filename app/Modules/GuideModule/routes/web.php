<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/guias', 'GuideModule\Controllers\GuideController')->names('guias')->except('store');
    Route::post('/guias/store', 'GuideModule\Controllers\GuideController@store')->name('guide.store');

<<<<<<< HEAD
    Route::post('pordespachar/packaging/{id}', 'GuideModule\Controllers\GuideController@porDespacharPackaging');
    Route::get('orders_packing/{type}', 'GuideModule\Controllers\GuideController@guidesForDeliveryPacking');
=======
    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'GuideModule\Controllers\GuideController@guidesForDeliveryPacking');

    Route::post('pordespachar/packaging/{id}', 'GuideModule\Controllers\GuideController@porDespacharPackaging');
>>>>>>> 469c1b60f2913f20989c66e0316aa88fb8431949
});
