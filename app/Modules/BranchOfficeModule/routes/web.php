<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/unassigned_branch_offices', 'BranchOfficeModule\Controllers\BranchOfficeController@unassigned_branch_offices');
    Route::get('/sucursales/{parent_id}', 'BranchOfficeModule\Controllers\BranchOfficeController@index')->name('branchOffices.index');
    Route::get('/sucursales/{parent_id}/create', 'BranchOfficeModule\Controllers\BranchOfficeController@create')->name('branchOffices.create');
    Route::post('/sucursales/{parent_id}/store', 'BranchOfficeModule\Controllers\BranchOfficeController@store')->name('branchOffices.store');
    Route::get('/sucursales/{parent_id}/{id}', 'BranchOfficeModule\Controllers\BranchOfficeController@show')->name('branchOffices.show');
    Route::get('/sucursales/{parent_id}/{id}/edit', 'BranchOfficeModule\Controllers\BranchOfficeController@edit')->name('branchOffices.edit');
    Route::put('/sucursales/{parent_id}/{id}/update', 'BranchOfficeModule\Controllers\BranchOfficeController@update')->name('branchOffices.update');
    Route::delete('sucursales/{parent_id}/{id}', 'BranchOfficeModule\Controllers\BranchOfficeController@destroy')->name('branchOffices.delete');
    Route::get('/allBranches', 'BranchOfficeModule\Controllers\BranchOfficeController@allBranches');
});
