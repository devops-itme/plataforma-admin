<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('guide/update-additional-information', 'GuideModule\Controllers\Api\GuideController@updateAdditionalInformation');
    Route::post('guide/markAsRead', 'GuideModule\Controllers\Api\GuideController@markAsRead');
    Route::resource('guides', 'GuideModule\Controllers\Api\GuideController')->names('guides-api');
    Route::put('guide/changeStatus', 'GuideModule\Controllers\Api\GuideController@changeStatus');
});

Route::get('tealca/destination', 'GuideModule\Controllers\ShipmentController@getDestinationTealca');
Route::get('tealca/stores', 'GuideModule\Controllers\ShipmentController@getTiendasTealca');
Route::post('tealca/create/send', 'GuideModule\Controllers\ShipmentController@storeGuideByservice');