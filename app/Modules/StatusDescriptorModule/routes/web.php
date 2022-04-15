<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('descriptor-estado/{id}', 'StatusDescriptorModule\Controllers\StatusDescriptorController@index')->name('statusDescriptor.index');
    //Store
    Route::post('descriptor-estado/{id}', 'StatusDescriptorModule\Controllers\StatusDescriptorController@store')->name('statusDescriptor.store');
    Route::delete('descriptor-estado/{id}', 'StatusDescriptorModule\Controllers\StatusDescriptorController@destroy')->name('statusDescriptor.destroy');
});
