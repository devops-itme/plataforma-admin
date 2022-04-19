<?php

namespace App\Modules\ApiConnectionsModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ApiConnectionsModule\Imports\ShipmentTealcaImport;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TealcaController extends Controller
{
    use RestActions;

    public function importShipments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'nullable',
            'file' => 'required | mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        $Tealca = new Tealca();
        // $loginResponse = $Tealca->login();

        // if ($loginResponse['state'] != 200) {
        //     return $loginResponse;
        // };

        // $order_id = $request->order_id;

        if (!$request->hasFile('file')) {
            return $this->respond(500,  [], '', 'Error al importar archivo');
        }
        $file_import = $request->file('file');
        Excel::import(new ShipmentTealcaImport(), $file_import);
        return $this->respond(200,  [], null, 'Importación de guías completada');
    }
}
