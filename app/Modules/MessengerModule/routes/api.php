<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('messenger/show', 'MessengerModule\Controllers\Api\MessengerController@show')->name('messenger.show');
    Route::put('messenger/update', 'MessengerModule\Controllers\Api\MessengerController@update')->name('messenger.update');
});
