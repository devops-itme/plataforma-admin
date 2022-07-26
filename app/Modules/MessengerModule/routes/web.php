<?php


use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        Route::resource('mensajeros', 'MessengerModule\Controllers\MessengerController')->names('messengers');
    });
    //Messengers delivery
    Route::get('messengers_delivery', 'MessengerModule\Controllers\MessengerController@messengersForDelivery');
    Route::get('contra/{id}/download', 'MessengerModule\Controllers\MessengerController@download')->name('contra.download');
    Route::post('mensajeros/import', 'MessengerModule\Controllers\MessengerController@importMessenger')->name('messengers.import');
});
