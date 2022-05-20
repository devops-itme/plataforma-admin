<?php

namespace App\Modules\OrderModule\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuideModule\Guide;
use App\Modules\ApiConnectionsModule\Imports\ShipmentTealcaImport;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ShipmentController extends Controller
{
    use RestActions;

    protected $path = 'OrderModule.views.html.international.shipments.';

    public function index(Request $request)
    {
        $order_id = $request->order_id;
        $Guide = new Guide();
        $response = $Guide->getGuidesByOrder($order_id, (request()->pagination ?? 15));
        if ($response['state'] != 200) {
            return redirect()->back()->with('warning', 'Orden no encontrada');
        };
        $shipments = $response['data'];
        return view($this->path . 'index', compact('shipments'));
    }

    public function importBatch(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'excel' => 'required|mimes:xlsx',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        $file = $request->file('excel');
        Excel::import(new ShipmentTealcaImport, $file);
        return redirect()->route('internationalOrders.index')->with('success', 'Lote creado correctamente');
    }

    public function sendBatch($id)
    {
        $Guide = new Guide();
        $Tealca = new Tealca();
        $Tealca->login();
        $guideResponse = $Guide->getGuidesByOrder($id, false);
        if ($guideResponse['state'] != 200) {
            return $guideResponse;
        }
        $guides = $guideResponse['data'];
        foreach ($guides as $guide) {
            if($guide->external_id != NULL){
                continue;
            }
            $response = $Tealca->requestCreateShipment($guide);
            if ($response['state'] != 200) {
                return redirect()->back()->with('danger', $response['message']);
            }
        }
        return redirect()->route('internationalOrders.index')->with('success', 'Lote subido correctamente');
    }
}
