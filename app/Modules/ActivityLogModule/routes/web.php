<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('log', 'ActivityLogModule\Controllers\LogController@index')->name('log.index');
});
