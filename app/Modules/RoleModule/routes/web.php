<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('roles', 'RoleModule\Controllers\RoleController')->names('roles');
});
