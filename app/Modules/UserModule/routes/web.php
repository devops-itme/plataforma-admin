<?php

use Illuminate\Support\Facades\Route;
Route::get('imporUsers', 'UserModule\Controllers\UserController@importWebUsers')->name('import.webUsers');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role'], function () {
        Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');
    });
    Route::resource('perfil', 'UserModule\Controllers\ProfileController')->names('profile');

    //PROFILE PHOTO ROUTES
    Route::post('image-upload','UserModule\Controllers\ProfileController@imageUploadPost' )->name('image.upload.post');
    Route::put('image-update','UserModule\Controllers\ProfileController@imageUpdatePost' )->name('image.update.post');
});
