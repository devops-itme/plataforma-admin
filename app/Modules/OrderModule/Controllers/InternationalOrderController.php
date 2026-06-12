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
use Maatwebsite\Excel\HeadingRowImport;
use App\Modules\ApiConnectionsModule\Imports\GuidesToBatchImport;
use Illuminate\Support\Facades\Http;
use App\Modules\ApiConnectionsModule\Models\ApiSync;
use App\Modules\ApiConnectionsModule\Models\Coordinadora;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\ApiConnectionsModule\Imports\ShipmentCoordinadoraImport;
use App\Modules\ApiConnectionsModule\Imports\ShipmentCoordinadoraImp;
use Illuminate\Support\Facades\Log;

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

    public function importVendorBatch(Request $request)
    {
        return 1;
    }

    public function importBatch(Request $request)
    {   
        //Log::debug("Entro a import batch");
        //dd($request->all());
        if ($request->provider == 2) {
            $response = $this->importCoordinadoraBatch($request);
            return $response;

        } else {
            //Log::debug("entro al else batch");
            $response = $this->importTealcaBatch($request);
            return $response;
        }
        
    }

    public function importTealcaBatch(Request $request)
    {
        //set_time_limit(3200);
        //Log::debug("Entro a importTealcaBatch");
        $ApiSync = new ApiSync;
        //dd($request->excel->getClientOriginalName());
        $userData = auth()->user();
        $unique_phone = $request->unique_phone === 'true';
        $customer_id = $request->customer_id;
        $file = $request->file('excel');
        $headings = (new HeadingRowImport)->toArray($file);
        $TealcaImport = new ShipmentTealcaImport($unique_phone,$customer_id);
        
        $header = ["paisdes",
                    "ciudes",
                    "nomdes",
                    "dirdes",
                    "documenttypedes",
                    "documentnumberdes",
                    "teldes",
                    "email",
                    "oficinadeentrega",
                    "preguia",
                    "numfactura",
                    "declarado",
                    "piezas",
                    "kilos",
                    "namecontact",
                    "observ"];
        
                    Log::debug("paso instanciamiento de parametros");
        $missingColumns = array_diff($header, $headings[0][0]);
        if (count($missingColumns) == 1) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email ?? null
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "error",
                    'response_error' => "missing_header_".implode($missingColumns).""
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', 'Error. No se encontró la columna '. implode($missingColumns). '.');
        }
        if (count($missingColumns) > 1) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email ?? null
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "error",
                    'response_error' => "missing_header_".implode($missingColumns).""
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', 'Error. No se encontraron las columnas '. implode(", ", $missingColumns). '.');
        }
        //Log::debug("paso validaciones de datos vacios");
        $validator = Validator::make(
            $request->all(),
            [
                'customer_id' => 'required',
                'excel' => 'required|mimes:xlsx',
            ]
        );
        if ($validator->fails()) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email ?? null
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "validation_error",
                    'response_error' => $validator->errors()->first()
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', $validator->errors()->first());
        }
        //Log::debug("paso validtor");
    
        ini_set('memory_limit', '-1');
        set_time_limit(3200);

        $excelResponse = Excel::import($TealcaImport, $file);
        
        //Log::debug("pasó import()");
        if ($TealcaImport->getWrongRow() > 0) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "error",
                    'response_error' =>"wrong_city_in_row_".$TealcaImport->getWrongRow().""
                ),
                "ACK"
            );
            return redirect()->route('internationalOrders.index')->with('danger', 'Error en la fila '.$TealcaImport->getWrongRow().': ciudad no encontrada. Porfavor verifique e intente nuevamente.');
        }

        unset($TealcaImport);
        gc_collect_cycles();
        //$ApiSync->authenticate();
        $ApiSync->ApiSaveLog(
            "Multientrega_Admin",
            array(
                'origin_user' => $userData->email
            ),
            "Multientrega_DB",
            array(
                'destination_table' => "guides",
                'destination_action' => "create"
            ),
            array(
                'payload_action' => "import_batch",
                'payload_file_name' => $request->excel->getClientOriginalName()
            ),
            array(
                'response' => "imported_batch",
            ),
            "ACK"
        );
        //Log::debug("paso retorno exitoso");
        return redirect()->route('internationalOrders.index')->with('success', 'Lote creado correctamente');
    }


    //Import guides to batch
    public function addGuidesToBatch(Request $request, $order_id)
    {   //dd($request->all());
        $ApiSync = new ApiSync;
        $userData = auth()->user();
        $unique_phone = $request->unique_phone === 'true';
        $customer_id = $request->customer_id;
        $file = $request->excel;
        
        $headings = (new HeadingRowImport)->toArray($file);
        $TealcaImport = new GuidesToBatchImport($unique_phone, $customer_id, $order_id);
        
        $header = ["paisdes",
                    "ciudes",
                    "nomdes",
                    "dirdes",
                    "documenttypedes",
                    "documentnumberdes",
                    "teldes",
                    "email",
                    "oficinadeentrega",
                    "preguia",
                    "numfactura",
                    "declarado",
                    "piezas",
                    "kilos",
                    "namecontact",
                    "observ"];
        
        
        $missingColumns = array_diff($header, $headings[0][0]);
        if (count($missingColumns) == 1) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_guides_to_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "error",
                    'response_error' => "missing_header_".implode($missingColumns).""
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', 'Error. No se encontró la columna '. implode($missingColumns). '.');
        }
        if (count($missingColumns) > 1) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_guides_to_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "error",
                    'response_error' => "missing_header_".implode($missingColumns).""
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', 'Error. No se encontraron las columnas '. implode(", ", $missingColumns). '.');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'excel' => 'required|mimes:xlsx',
            ]
        );
        if ($validator->fails()) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email
                ),
                "Multientrega_DB",
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_guides_to_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "validation_error",
                    'response_error' => "wrong_row_".$validator->errors()->first().""
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', $validator->errors()->first());
        }

        $excelResponse = Excel::import($TealcaImport, $file);
        if ($TealcaImport->getWrongRow() > 0) {
            //$ApiSync->authenticate();
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email
                ),
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'destination_table' => "guides",
                    'destination_action' => "create"
                ),
                array(
                    'payload_action' => "import_guides_to_batch",
                    'payload_file_name' => $request->excel->getClientOriginalName()
                ),
                array(
                    'response' => "error",
                    'response_error' => "wrong_city_in_row_".$TealcaImport->getWrongRow().""
                ),
                "ACK"
            );
            return redirect()->back()->with('danger', 'Error en la fila '.$TealcaImport->getWrongRow().': ciudad no encontrada. Porfavor verifique e intente nuevamente.');
        }

        //$ApiSync->authenticate();
        $ApiSync->ApiSaveLog(
            "Multientrega_Admin",
            array(
                'origin_user' => $userData->email
            ),
            "Multientrega_DB",
            array(
                'destination_table' => "guides",
                'destination_action' => "create"
            ),
            array(
                'payload_action' => "import_guides_to_batch",
                'payload_file_name' => $request->excel->getClientOriginalName()
            ),
            array(
                'response' => "batch_updated"
            ),
            "ACK"

        );
        return redirect()->back()->with('success', 'Guías cargadas correctamente');
    }

    public function exportBatch(Request $request)
    {   
        return  Excel::download(
            new OrdersExport($request->from, $request->to, $request->name),
            'Órdenes Internacionales.xlsx'
        );
    }


    public function incidencesExport()
    {
        $guides = Guide::select('id', 'external_id', 'contact')->where('external_id', '<>', null)
            ->where('state', '1')->get();
            $incidences = [];
        $Tealca = new Tealca();
        $Tealca->login();
        foreach ($guides as $guide) {
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
    
    /***** COORDINADORA *****/

    public function createCoordinadoraGuide(Request $request)
    {
        $CoordinadoraModel = new CoordinadoraModel();
        $petition = $CoordinadoraModel->createCoordinadoraGuide($request);
        return $petition;
    }

    public function getCoordinadoraGuide($id)
    {
        $CoordinadoraModel = new CoordinadoraModel();
        $petition = $CoordinadoraModel->getCoordinadoraGuide($id);
        return $petition;
    }

    public function updateCoordinadoraGuides(Request $request, $id)
    {
        $CoordinadoraModel = new CoordinadoraModel();
        $petition = $CoordinadoraModel->updateCoordinadoraGuide($request, $id);
        return $petition;
    }

    public function deleteCoordinadoraGuide($id)
    {
        $CoordinadoraModel = new CoordinadoraModel();
        $petition = $CoordinadoraModel->deleteCoordinadoraGuide($id);
        return $petition;
    }

    public function importCoordinadoraBatch(Request $request)
    {
        $customer_id = $request->customer_id;
        $file = $request->file('excel');
        $CoordinadoraImport = new ShipmentCoordinadoraImport($customer_id, $request->country);
        $headings = (new HeadingRowImport)->toArray($file);
        
        $header = [
            "codigo_ciudad_destinatario",
            "nombre_ciudad_destinatario",
            "codigo_pedido",
            "numero_pedido",
            "es_entrega_mismo_dia",
            "valor_declarado",
            "referencia",
            "unidades",
            "peso",
            "alto",
            "ancho",
            "largo",
            "nombre_empaque"
        ];
        
        
        $missingColumns = array_diff($header, $headings[0][0]);
        if (count($missingColumns) == 1) {
            return redirect()->back()->with('danger', 'Error. No se encontró la columna '. implode($missingColumns). '.');
        }
        if (count($missingColumns) > 1) {
            return redirect()->back()->with('danger', 'Error. No se encontraron las columnas '. implode(", ", $missingColumns). '.');
        }
        $excelResponse = Excel::import($CoordinadoraImport, $file);
        if ($CoordinadoraImport->getWrongRow() > 0) {
            return redirect()->route('internationalOrders.index')->with('danger', 'Error en la fila '.$CoordinadoraImport->getWrongRow().': código de ciudad no encontrado. Porfavor verifique e intente nuevamente.');
        }
        return redirect()->route('internationalOrders.index')->with('success', 'Lote creado correctamente');
    }


    public function addGuidesToBatchCoordinadora(Request $request, $order_id)
    {
        return 1;
    }
}
