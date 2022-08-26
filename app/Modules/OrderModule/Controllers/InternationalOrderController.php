<?php

namespace App\Modules\OrderModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\OrderModule\Exports\OrdersExport;
use App\Modules\ApiConnectionsModule\Imports\ShipmentTealcaImport;
use App\Modules\ApiConnectionsModule\Exports\TealcaInformExport;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use App\Modules\CustomerModule\Customer;
use App\Modules\GuideModule\Guide;
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
    public function index(Request $request)
    {
        $orders = Order::number($request->get('number'))
            ->whereOrderType(request()->order_type)
            ->customer(request()->name)
            ->date(request()->from, request()->to)
            ->whereStatusMatrix([request()->state])
            ->with('getStatusMatrix')->whereHas('getStatusMatrix', function ($query) {
                $query->where('name', '!=', 'ENTREGADO');
            })
            ->international()
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $status_matrix = StatusMatrix::get();
        $customers = Customer::whereHas('getUser', function ($query) {
            $query->whereHas('getRole', function ($query) {
                $query->where('name', 'Cliente');
            });
        })->get();

        return view($this->path . 'index', compact('orders', 'order_type', 'status_matrix','customers'));
    }

    public function show($id)
    {
    }

    public function importBatch(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'customer_id' => 'required',
                'excel' => 'required|mimes:xlsx',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        $unique_phone = $request->unique_phone === 'true';
        $customer_id = $request->customer_id;
        $file = $request->file('excel');
        $excelResponse = Excel::import(new ShipmentTealcaImport($unique_phone,$customer_id), $file);
        // dd($excelResponse);
        return redirect()->route('internationalOrders.index')->with('success', 'Lote creado correctamente');
    }


    public function exportBatch(Request $request)
    {
        return  Excel::download(new OrdersExport(), 'Órdenes Internacionales.xlsx');
    }


    public function incidencesExport()
    {
        $guides = Guide::select('id', 'external_id', 'contact')->where('external_id', '<>', null)
            ->where('state', '1')->get();
        $incidences = [];
        foreach ($guides as $guide) {
            $Tealca = new Tealca();
            $Tealca->login();
            $guideTracking = $Tealca->requestOrderStatus($guide->external_id);
            // $statuses = json_decode($guideTracking)->tracking;
            $statuses = $guideTracking['data'][0]['tracking'][0];
            $status   = $guideTracking['data'][0]['tracking'][0]['status'];
            $order1 = json_decode($guide);
            foreach ($statuses as $status) {
                if ($status ==   'Incidencia') {
                    $order1->Status = $status;
                    $order1->Fecha = date('Y/m/d H:i:s', strtotime($statuses['date']));
                    $order1->description = $statuses['description'];
                    $incidences[] = $order1;
                }
            }
        }
        $export = new TealcaInformExport($incidences);
        return Excel::download($export, 'Informe.xlsx');
    }
}
