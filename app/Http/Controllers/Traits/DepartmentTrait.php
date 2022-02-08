<?php

namespace App\Http\Controllers\Traits;

use App\Department;
use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\ParameterValue;
use App\User;
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
            if (!is_null(Request()->user_id)) {
                $user_id  = Request()->user_id;
                $departments = Department::with('getBranchOffice.getUser')->whereHas('getBranchOffice.getUser', function ($query) use ($user_id) {
                    $query->where('id', $user_id);
                })->paginate(10);
            } else {
                $branch_id = Request()->branch_office_id;
                $departments = Department::where('branch_office_id', $branch_id)->with('getBranchOffice.getUser')->paginate(10);
            }


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
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {
            $department = Department::create([
                'branch_office_id' => $request->branch_office_id,
                'name' => $request->name,
                'state' => $request->state ?? 1,
                'description' => $request->description,
            ]);
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
                return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
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
