<?php


use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        // Route::resource('mensajeros', 'MessengerModule\Controllers\UserController')->names('messengers');
        //  Route::resource('mensajeros', 'Admin\MessengerController')->names('messengers');
    });
});
