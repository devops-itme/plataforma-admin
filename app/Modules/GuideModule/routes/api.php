<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('guide/update-additional-information', 'GuideModule\Controllers\Api\GuideController@updateAdditionalInformation');
    Route::post('guide/markAsRead', 'GuideModule\Controllers\Api\GuideController@markAsRead');
    Route::resource('guides', 'GuideModule\Controllers\Api\GuideController')->names('guides');
    Route::put('guide/changeStatus', 'GuideModule\Controllers\Api\GuideController@changeStatus')->name('guide.changeStatus');
    Route::post('guide/saveEvidence', 'GuideModule\Controllers\Api\GuideController@saveEvidence');
});
