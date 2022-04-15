<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('matriz-estados', 'StatusMatrixModule\Controllers\StatusMatrixController@index')->name('statusMatrix.index');
});
