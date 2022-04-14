<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('parametros', 'ParametersModule\Controllers\ParameterController')->except('destroy')->names('parameters');
    Route::delete('parametros/delete/{id}', 'ParametersModule\Controllers\ParameterController@destroy')->name('parameters.destroy');
});
