<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('guide-log', 'GuideLogModule\Controllers\Api\GuideLogController')->names('guide-log-api');
});

Route::get('get_guides', 'GuideLogModule\Controllers\Api\GuideLogController@obtainGuideLogs');


