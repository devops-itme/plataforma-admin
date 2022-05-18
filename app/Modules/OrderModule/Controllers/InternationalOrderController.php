<?php

namespace App\Modules\OrderModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuideModule\Guide;
use App\Modules\OrderModule\Imports\BatchImport;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class InternationalOrderController extends Controller
{
    use RestActions;

    protected $path = 'OrderModule.views.html.international.';
    public function index()
    {
        $orders = Order::paginate(10);
        // $orders = InternationalOrder::number(request()->number)
        //     ->order_type(request()->order_type)
        //     ->customer(request()->name)
        //     ->date(request()->from, request()->to)
        //     ->whereStatusMatrix([request()->state])
        //     ->with('getStatusMatrix')->whereHas('getStatusMatrix', function ($query) {
        //         $query->where('name', '!=', 'ENTREGADO');
        //     })->paginate(10);
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $status_matrix = StatusMatrix::get();
        return view($this->path . 'index', compact('orders', 'order_type', 'status_matrix'));
    }

    public function show($id)
    {
        $Guide = new Guide();
        $response = $Guide->getGuidesByOrder($id);
        if ($response['state'] != 200) {
            return redirect()->back()->with('warning', 'Orden no encontrada');
        };
        $shipments = $response['data'];
        return view($this->path . 'shipments.index', compact('shipments'));
    }

    public function sendBatch($id)
    {
        return 1;
    }

    public function importBatch(Request $request)
    {
        // try {
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
        Excel::import(new BatchImport, $file);
        return redirect()->route('internationalOrders.index')->with('success', 'Lote creado correctamente');
        // } catch (\Exception $e) {
        //     return $this->respond(500, null, $e->getMessage(), 'Problemas al cargar el archivo');
        // }
    }
}
