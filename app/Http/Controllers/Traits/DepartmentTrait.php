<?php

namespace App\Http\Controllers\Traits;

use App\Department;
use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\ParameterValue;
use App\User;
use App\UserDeparment;
use Illuminate\Http\Request;
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
        try {


            $departments = Department::get();
            $allAssignedDepartments = UserDeparment::get('department_id');

            $departments_id = $allAssignedDepartments->map(function ($item, $key) {
                return $item->department_id;
            });

            $departments = Department::whereNotIn('id', $departments_id)->get();

            return $this->respond(200, $departments);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showDepartment($id)
    {
        try {
            $department = Department::where('id', $id)->first();
            return $this->respond(200, $department);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function saveDepartment($request)
    {
        $validator = $this->departmentValidate($request);
        if ($validator->fails()) {
            return $this->respond(500, [] ,$validator->errors(),  $validator->errors()->first());
        }
        try {
            $department = Department::create($request->all());
            return $this->respond(200, $department, null, 'Departamento creado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear departamento');
        }
    }
    public function updateDepartment($request, $id)
    {
        try {
            $validator = $this->departmentValidate($request);
            if ($validator->fails()) {
                return $this->respond(500, [],  $validator->errors(),  $validator->errors()->first());
            }
            $department = Department::find($id);
            $department->update($request->all());

            return $this->respond(200, $department, null, 'Departamento actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar departamento');
        }
    }
    public function deleteDepartment($id)
    {
        try {
            $department = Department::find($id);
            $department->delete();
            return $this->respond(200, $department, null, 'Departamento eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar departamento');
        }
    }
}
