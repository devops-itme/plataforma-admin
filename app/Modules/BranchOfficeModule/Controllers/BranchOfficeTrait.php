<?php

namespace App\Modules\BranchOfficeModule\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\BranchOffice;
use App\DepartmentBranch;
use App\UserBranch;
use App\UserDepartment;
use Illuminate\Validation\Rule;

trait BranchOfficeTrait
{
    // use UserTrait;
    use RestActions;

    public function branchOfficeValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'branch_office_name' => 'required|string',
                'branch_office_type' => 'required|numeric',
                'branch_office_description' => 'required|string',
                'branch_office_zone' => 'required|numeric',
                'branch_office_address' => 'required|string',
                'branch_office_lat' => 'nullable|string',
                'branch_office_lng' => 'nullable|string',
                'branch_office_email' => 'required|email',
                'branch_office_contact' => 'required|string',
                'branch_office_document_type' => 'required|numeric',
                'branch_office_document_number' => 'required|numeric',
                'branch_office_default' => 'nullable',
                'branch_office_payment_method' => 'required|numeric',
                'branch_office_phone' => 'required|string',
                'branch_office_plan' => [
                    'nullable', Rule::requiredIf($request->branch_office_payment_method != 25), 'numeric'
                ],
                'branch_office_usage_mode' => [
                    'nullable', Rule::requiredIf($request->branch_office_payment_method != 25), 'numeric'
                ],
                'user_id' => 'nullable|exists:users,id',
            ]
        );
    }

    public function saveBranchOffice($request)
    {
        $validator = $this->branchOfficeValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' , $validator->errors()->first());
        }
        try {
            if($request->branch_office_default == 1){
                $defaultOffice = BranchOffice::where('default', 1)->first();
                if(!is_null($defaultOffice)){
                    $defaultOffice->update(['default' => 0]);
                }
            }
            $branchOffice = BranchOffice::create([
                'name' => $request->branch_office_name,
                'description' => $request->branch_office_description,
                'type' => $request->branch_office_type,
                'zone_id' => $request->branch_office_zone,
                'address' => $request->branch_office_address,
                'email' => $request->branch_office_email,
                'contact' => $request->branch_office_contact,
                'document_type' => $request->branch_office_document_type,
                'document_number' => $request->branch_office_document_number,
                'lat' => $request->branch_office_lat,
                'lng' => $request->branch_office_lng,
                'default' => $request->branch_office_default,
                'payment_method' => $request->branch_office_payment_method,
                'phone' => $request->branch_office_phone,
                'plan' => $request->branch_office_plan,
                'usage_mode' => $request->branch_office_usage_mode,
                'user_id' => $request->user_id ?? NULL
            ]);
            return $this->respond(200, $branchOffice, null, 'Sucursal creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear oficina');
        }
    }

    public function updateBranchOffice($request)
    {
        $validator = $this->branchOfficeValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $branchOffice = BranchOffice::find($request->office_id);
            if (is_null($branchOffice)) {
                return $this->respond(500, [], 'user not found', 'No se encontró la oficina');
            }
            // if($request->branch_office_default == 1){
            //     $defaultOffice = BranchOffice::where('default', 1)->first();
            //     if(!is_null($defaultOffice)){
            //         $defaultOffice->update(['default' => 0]);
            //     }
            // }
            $branchOffice->update([
                'name' => $request->branch_office_name,
                'description' => $request->branch_office_description,
                'type' => $request->branch_office_type,
                'zone_id' => $request->branch_office_zone,
                'address' => $request->branch_office_address,
                'email' => $request->branch_office_email,
                'contact' => $request->branch_office_contact,
                'document_type' => $request->branch_office_document_type,
                'document_number' => $request->branch_office_document_number,
                'lat' => $request->branch_office_lat,
                'lng' => $request->branch_office_lng,
                'default' => $request->branch_office_default,
                'payment_method' => $request->branch_office_payment_method,
                'phone' => $request->branch_office_phone,
                'plan' => $request->branch_office_plan,
                'usage_mode' => $request->branch_office_usage_mode
            ]);
            return $this->respond(200, $branchOffice, null, 'Oficina actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar oficina');
        }
    }

    public function deleteBranchOffice($id)
    {
        try {
            $branchOffice = BranchOffice::find($id);
            if (is_null($branchOffice)) {
                return $this->respond(500, [], 'user not found', 'No se encontró la oficina');
            }
            $branchOffice->delete();
            return $this->respond(200, $branchOffice, null, 'Oficina eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar oficina');
        }
    }

    public function storeUserBranch($user_id, $offices)
    {
        try {
            if(is_array($offices)){
                foreach ($offices as $key) {
                    UserBranch::create([
                        'user_id' => $user_id,
                        'branch_office_id' => $key
                    ]);
                }
            } else {
                UserBranch::create([
                    'user_id' => $user_id,
                    'branch_office_id' => $offices
                ]);
            }
            return $this->respond(200, [], null, 'Sucursales asignadas de forma correcta');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al asignar la sucursal');
        }
    }

    public function storeUserDepartment($user_id, $departments)
    {
        try {
            foreach ($departments as $key) {
                UserDepartment::create([
                    'user_id' => $user_id,
                    'department_id' => $key
                ]);
            }
            return $this->respond(200, [], null, 'Departamentos asignadas de forma correcta');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al asignar la sucursal');
        }
    }
    public function storeBranchDepartment($branch, $department)
    {
        try {
            $data = DepartmentBranch::create([
                'branch_office_id' => $branch,
                'department_id' => $department
            ]);
            return $this->respond(200, $data, null, 'Departamentos asignado de forma correcta');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al asignar el departamento');
        }
    }
}
