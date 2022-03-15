<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait StatusMatrixTrait
{
    use TraitsRestActions;


    public function validateStatusMatrix($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [

            ]
        );
    }

}
