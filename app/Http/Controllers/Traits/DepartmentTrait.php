<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\ParameterValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use Illuminate\Support\Facades\Validator;

trait DepartmentTrait
{
    use TraitsRestActions;

    public function departmentValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'description' => 'nullable',
            ]
        );
    }
    public function getDepartments()
    {

    }
    public function showDepartment($id)
    {

    }
    public function saveDepartment($request, $id)
    {

    }
    public function updateDepartment($request, $id)
    {

    }
    public function deleteDepartment($id)
    {

    }
}
