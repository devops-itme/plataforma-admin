<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/clientes', 'app\Modules\CustomerModule\Controllers\CustomerController')->except('store')->names('customers');
    Route::post('/clientes/store', 'app\Modules\CustomerModule\Controllers\CustomerController@store')->name('customers.store');
});

