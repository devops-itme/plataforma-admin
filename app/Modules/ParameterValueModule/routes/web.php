<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('valor-parametros', 'ParameterValueModule\Controllers\ParameterValueController')->names('parameter_value');
});
