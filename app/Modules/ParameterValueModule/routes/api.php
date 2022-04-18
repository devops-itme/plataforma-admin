<?php

use Illuminate\Support\Facades\Route;

Route::get('parameter_values', 'ParameterValueModule\Controllers\Api\ParameterValueController@getParameterValues');
Route::get('status_matrix', 'ParameterValueModule\Controllers\Api\ParameterValueController@getStatusMatrix');