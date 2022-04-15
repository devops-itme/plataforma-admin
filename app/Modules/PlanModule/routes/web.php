<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('planes', 'PlanModule\Controllers\PlanController')->names('plans');
});
