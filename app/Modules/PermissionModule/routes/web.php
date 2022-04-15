<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('permisos', 'PermissionModule\Controllers\PermissionController')->names('permits');
    Route::get('permisos/getPermissions/{role_id}', 'PermissionModule\Controllers\PermissionController@getPermissions')->name('permits.getPermissions');
});
