<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('log', 'ActivityLogModule\Controllers\ActivityLogController@index')->name('log.index');
});
