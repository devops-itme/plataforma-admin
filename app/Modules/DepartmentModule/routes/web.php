<?php


use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        Route::resource('departamentos', 'DepartmentModule\Controllers\DepartmentController')->names('departments');
    });
    Route::get('unassigned_depts', 'DepartmentModule\Controllers\DepartmentController@UnassignedDepts');
});
