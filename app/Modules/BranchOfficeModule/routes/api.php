<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('branch-offices', 'BranchOfficeModule\Controllers\Api\BranchOfficeController')->names('branchOffices');
});
