<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        //USER
        Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');

        //CUSTOMER
        Route::resource('/clientes', 'CustomerModule\Controllers\CustomerController')->except('store')->names('customers');
        Route::post('/clientes/store', 'CustomerModule\Controllers\CustomerController@store')->name('customers.store');
    });
});
