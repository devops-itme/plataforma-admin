<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    //DOCUMENTOS DE GUIÁS
    Route::resource('/guias_doc', 'GuidanceDocumentModule\Controllers\GuidanceDocumentController')->names('guias_doc');
});
