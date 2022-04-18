<?php

namespace App\Modules\BranchOfficeModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\BranchOfficeModule\BranchOffice;
use Illuminate\Http\Request;

class BranchOfficeController extends Controller
{
    use RestActions;

    public function index(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $branch_offices = BranchOffice::whereUserId($user_id)->get();
            return $this->respond(200, $branch_offices, null, 'Lista de sucursales');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function show($branch_office_id)
    {
        try {
            $branch_office = BranchOffice::find($branch_office_id);
            return $this->respond(200, $branch_office, null, 'Detalle de la sucursal');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
