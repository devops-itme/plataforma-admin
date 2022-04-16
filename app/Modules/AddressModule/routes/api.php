<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::resource('address', 'AddressModule\Controllers\Api\AddressController')->names('address');
    Route::get('address', 'AddressModule\Controllers\Api\AddressController@index')->name('address.index');
    Route::post('address/store', 'AddressModule\Controllers\Api\AddressController@store')->name('address.store');
    Route::put('address/update/{id}', 'AddressModule\Controllers\Api\AddressController@update')->name('address.update');
    Route::delete('address/{id}', 'AddressModule\Controllers\Api\AddressController@destroy')->name('address.delete');
});
