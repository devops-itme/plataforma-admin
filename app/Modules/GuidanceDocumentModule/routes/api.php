<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('guide/getEvidence', 'GuidanceDocumentModule\Controllers\Api\GuidanceDocumentController@getDocumentsByGuide');
    Route::post('guide/saveEvidence', 'GuidanceDocumentModule\Controllers\Api\GuidanceDocumentController@store');
});
