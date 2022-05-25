<?php
namespace App\Modules\GuideModule\Controllers;
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
    use RestActions, GuideTrait;
    protected $path = 'GuideModule.views.html.shipments.';
    public function index(Request $request)
    {
        $order_id = $request->order_id;
        $Guide = new Guide();
        $response = $Guide->getGuidesByOrder($order_id, (request()->pagination ?? 15));
        if ($response['state'] != 200) {
            return redirect()->back()->with('warning', 'Orden no encontrada');
        };
        $shipments = $response['data'];
        return view($this->path . 'index', compact('shipments', 'order_id'));
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
        return redirect()->route('shipments.index')->with('success', 'Lote subido correctamente');
    }
    public function create(Request $request){
        $order_id = $request->order_id;
        return view($this->path. 'create', compact('order_id'));
    }

    public function store (Request $request)
    {
        $response = $this->storeGuide($request);
        return back();
    }
}
