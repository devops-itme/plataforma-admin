<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\BranchOffice;
use App\UserBranch;

trait BranchOfficeTrait
{
    use UserTrait;

    public function branchOfficeValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'branch_office_name' => 'nullable|string',
                'branch_office_type' => 'nullable',
                'branch_office_description' => 'nullable|string',
                'branch_office_zone' => 'nullable',
                'branch_office_address' => 'nullable|string',
                'branch_office_lat' => 'nullable',
                'branch_office_lng' => 'nullable',
                'branch_office_email' => 'nullable|email',
                'branch_office_contact' => 'nullable|string',
                'branch_office_document_type' => 'nullable',
                'branch_office_document_number' => 'nullable|numeric',
                'branch_office_default' => 'nullable',
                'branch_office_payment_method' => 'nullable',
                'branch_office_phone' => 'nullable',
                'branch_office_usage_mode' => 'nullable',
                'user_id' => 'nullable|exists:users,id',
            ]
        );
    }

    public function saveBranchOffice($request)
    {
        $validator = $this->branchOfficeValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
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
                'usage_mode' => $request->branch_office_usage_mode,
                // 'user_id' => $request->user_id
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
                return $this->respond(500, [], 'user not found', 'No se encontro la oficina');
            }
            if($request->branch_office_default == 1){
                $defaultOffice = BranchOffice::where('default', 1)->first();
                if(!is_null($defaultOffice)){
                    $defaultOffice->update(['default' => 0]);
                }
            }
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
                return $this->respond(500, [], 'user not found', 'No se encontro la oficina');
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
            foreach ($offices as $key) {
                UserBranch::create([
                    'user_id' => $user_id,
                    'branch_office_id' => $key
                ]);
            }
            return $this->respond(200, [], null, 'Sucursales asignadas de forma correcta');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al asignar la sucursal');
        }
    }
}
