<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/clientes', 'CustomerModule\Controllers\CustomerController')->except('store')->names('customers');
    Route::post('/clientes/store', 'CustomerModule\Controllers\CustomerController@store')->name('customers.store');

    //USER BANKS
    Route::get('/usuario-banco/{parent_id}', 'CustomerModule\Controllers\CustomerController@UserBankIndex')->name('bankUsers.index');
    Route::get('/usuario-banco/{parent_id}/create', 'CustomerModule\Controllers\CustomerController@UserBankCreate')->name('bankUsers.create');
    Route::post('/usuario-banco/{parent_id}/store', 'CustomerModule\Controllers\CustomerController@UserBankStore')->name('bankUsers.store');
    Route::get('/usuario-banco/{parent_id}/{id}', 'CustomerModule\Controllers\CustomerController@UserBankShow')->name('bankUsers.show');
    Route::get('/usuario-banco/{parent_id}/{id}/edit', 'CustomerModule\Controllers\CustomerController@UserBankEdit')->name('bankUsers.edit');
    Route::put('/usuario-banco/{parent_id}/{id}/update', 'CustomerModule\Controllers\CustomerController@UserBankUpdate')->name('bankUsers.update');
    Route::delete('/usuario-banco/{parent_id}/{id}', 'CustomerModule\Controllers\CustomerController@UserBankDestroy')->name('bankUsers.delete');

    Route::get('/search_customers', 'CustomerModule\Controllers\CustomerController@search_customer');
    Route::get('/customer_data/{id}', 'CustomerModule\Controllers\CustomerController@customerData');
});

