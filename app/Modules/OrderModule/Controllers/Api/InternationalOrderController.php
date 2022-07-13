<?php

namespace App\Modules\OrderModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Modules\AddressModule\Address;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\AddressModule\Controllers\AddressTrait;
use App\Modules\GuideModule\Controllers\GuideTrait;
use App\Modules\OrderModule\Controllers\OrderTrait;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
use App\Modules\OrderModule\Exports\OrdersExportServices;
use App\Modules\GuideModule\Guide;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables;

class InternationalOrderController extends Controller
{
    use OrderTrait, GuideTrait, AddressTrait;

    public function respond($state, $data = [], $error = null, $message = '')
    {
        return [
            'state' => $state, //response status
            'data' => $data, //response data
            'error' => $error, //bug for developer
            'message' => $message //user message
        ];
    }

    protected $customerRelationships = [
        'getOrderType', 'getDocumentType', 'getPaymentMethod',
        'getState', 'getDepartment', 'getBranchOffice',
        'getScheduleTime', 'getScheduleTime.getDay'
    ];

    protected $messengerRelationships = [
        'getUser', 'getUser.getDocumentType',
        'getOrderType', 'getDocumentType', 'getPaymentMethod',
        'getState', 'getDepartment', 'getBranchOffice',
        'getScheduleTime', 'getScheduleTime.getDay'
    ];

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;


        try {
            $guides = DB::table('guides AS g')->select('g.id', 'g.external_id', 'g.contact','g.created_at')
                ->where('g.external_id', '<>', null)
                ->where('g.state', '1')
                ->join('orders as o', 'o.id', '=', 'order_id')
                ->join('users as u', 'u.id', '=', 'o.user_id')
                ->where('o.deleted_at', null)
                ->where('u.id', $user_id)
                ->get();


            $info_tealca = [];

            foreach ($guides as $guide) {
                // dd($guide);
                $order1 = $guide;
                $Tealca = new Tealca();
                $Tealca->login();
                $guideTracking = $Tealca->requestOrderStatus($guide->external_id);


                foreach ($guideTracking['data'] as $elements) {
                    foreach ($elements['tracking'] as $tracking) {
                        switch ($tracking['status']) {
                            case 'Creacion':
                                $tealca['Status'] ='VERIFICACION';
                                $tealca['description'] =$tracking['description'];
                                $tealca['city'] =$tracking['city'];
                                $tealca['state'] =$tracking['state'];
                                $tealca['description'] =$tracking['description'];
                                $tealca['locationZone'] =$tracking['locationZone'];
                                $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));

                                // $sumando['Status'] ='RECEPTADO A BODEGA';
                                // $sumando['description'] =$tracking['description'];
                                // $sumando['city'] =$tracking['city'];
                                // $sumando['state'] =$tracking['state'];
                                // $sumando['description'] =$tracking['description'];
                                // $sumando['locationZone'] =$tracking['locationZone'];
                                // $sumando['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                                // $order1->historical[]= $sumando;

                                $order1->historical[]=$tealca;
                                $info_tealca[] = $order1;
                                break;

                            case 'Recepcion desde plataforma':
                                $tealca['Status']  = 'RECEPTADO A BODEGA';
                                $tealca['description'] =$tracking['description'];
                                $tealca['city'] =$tracking['city'];
                                $tealca['state'] =$tracking['state'];
                                $tealca['description'] =$tracking['description'];
                                $tealca['locationZone'] =$tracking['locationZone'];
                                $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                                $order1->historical[]= $tealca;
                                $info_tealca[] = $order1;
                                break;

                            case 'Recepcion desde tienda':
                                $tealca['Status']  = 'RECEPCION EN SUCURSAL';
                                $tealca['description'] =$tracking['description'];
                                $tealca['city'] =$tracking['city'];
                                $tealca['state'] =$tracking['state'];
                                $tealca['description'] =$tracking['description'];
                                $tealca['locationZone'] =$tracking['locationZone'];
                                $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                                $order1->historical[]= $tealca;
                                $info_tealca[] = $order1;
                                break;

                            case 'Despacho a tienda(tienda destino para entrega al cliente)':
                                $tealca['Status']  = 'DESPACHO A SUCURSAL';
                                $tealca['description'] =$tracking['description'];
                                $tealca['city'] =$tracking['city'];
                                $tealca['state'] =$tracking['state'];
                                $tealca['description'] =$tracking['description'];
                                $tealca['locationZone'] =$tracking['locationZone'];
                                $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                                $order1->historical[]= $tealca;
                                $info_tealca[] = $order1;
                                break;
                        }
                    }
                }
            }


            return $this->respond(200,  $info_tealca, null, 'Ordenes Internacionales');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function services(Request $request)
    {
        $user_id = Auth::user()->id;

        $fecha_begin = date('Y-m-d 00:00:00', ($request->begin / 1000));
        $fecha_end = date('Y-m-d 23:59:59', ($request->end / 1000));

        $query = DB::select(DB::raw("SELECT g.external_id as external_id, g.contact as contact, g.created_at as AppEventDate
       FROM guides g
      JOIN orders o
      on o.id = g.order_id
      JOIN users as u
      on u.id = o.user_id
      WHERE u.id = '$user_id' and g.state = '1' and g.external_id is not null and o.deleted_at is null and g.created_at between '$fecha_begin' and '$fecha_end' "));

        foreach ($query as $guide) {
            // dd($guide);
            $order1 = $guide;
            $Tealca = new Tealca();
            $Tealca->login();
            $guideTracking = $Tealca->requestOrderStatus($guide->external_id);

            foreach ($guideTracking['data'] as $elements) {
                foreach ($elements['tracking'] as $tracking) {
                    switch ($tracking['status']) {
                        case 'Creacion':
                            $order1->Status = 'VERIFICACION';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $info_tealca[] = $order1;
                            break;

                        case 'Recepcion desde plataforma':
                            $order1->Status = 'RECEPTADO A BODEGA';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $info_tealca[] = $order1;
                            break;

                        case 'Recepcion desde tienda':
                            $order1->Status = 'RECEPCION EN SUCURSAL';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $info_tealca[] = $order1;
                            break;

                        case 'Despacho a tienda(tienda destino para entrega al cliente)':
                            $order1->Status = 'DESPACHO A SUCURSAL';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $info_tealca[] = $order1;
                            break;
                    }
                }
            }
        }
        return DataTables::of($query)
            /*->editColumn('Fecha', function($data){
        $fecha_plan =  substr($data->AppEventDate, 0, -9);
        return $fecha_plan;
      })*/
            ->addColumn('FechaTime', function ($data) {
                $AppEventDate = strtotime($data->Fecha);
                $texto =  $AppEventDate;
                return $texto;
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="javascript:;" class="ml-2 details" name="details" data-toggle="modal" (click)="open()" data-target="#myModal" data-placement="left" title="Detalles" id="' . $data->external_id . '"><i class="fa fa-eye fa-lg text-info" aria-hidden="true"></i></a>';
                return $button;
            })

            ->toJson();
    }

    public function permissionsAccions(Request $request, $id)
    {
        $array = array();
        $id_user = Auth::user()->id;
        // $permission_sql = DB::select( DB::raw("SELECT DISTINCT (ucm.id), uwug.grant_excel, uwug.grant_label FROM udpWebUserGrants uwug, udpClientModDocType ucmdt, udpClientModules ucm WHERE uwug.user_id = '$id_user' AND uwug.client_doctype_id = ucmdt.id AND ucm.id = ucmdt.module_id AND uwug.active = '1'"));
        $permission_sql = ['id' => 1, 'grant_excel' => 1, 'grant_label' => 1];
        return response()->json($permission_sql);
        // return 'Entro';
    }

    public function show_destinations($id){
        // $array_origen = array();
        // $array_destino = array();
        // $array_pedidos = array();
        // $array_intento = array();
        $query = DB::select(DB::raw("SELECT
         g.external_id as external_id,
         g.pre_guide as pre_guide,
         g.branch_office as branch_office,
         g.invoice_contact as invoice_contact,
         g.recipient_name as recipient_name,
         g.document_type as document_type,
         g.document as document,
         g.email_contact as email_contact,
         g.address_name as address_name,
         g.city as city,
         g.phone_contact as phone_contact,
         g.country as country,
         g.pieces as pieces,
         g.kg as kg,
         g.declared as declared,
         g.invoice_number as invoice_number,
         g.dispatched as dispatched,
         g.contact as contact,
         g.description as descripcion,
         g.novelty as novelty,
         g.delivery_office as delivery_office

       FROM guides g
      JOIN orders o
      on o.id = g.order_id
      JOIN users as u
      on u.id = o.user_id
      WHERE g.state = '1' and g.external_id = $id and o.deleted_at is null"));

foreach ($query as $guide) {
    // dd($guide);
    $order1 = $guide;
    $Tealca = new Tealca();
    $Tealca->login();
    $guideTracking = $Tealca->requestOrderStatus($guide->external_id);

    foreach ($guideTracking['data'] as $elements) {
        foreach ($elements['tracking'] as $tracking) {
            switch ($tracking['status']) {
                case 'Creacion':
                    $tealca['Status'] ='VERIFICACION';
                    $tealca['description'] =$tracking['description'];
                    $tealca['city'] =$tracking['city'];
                    $tealca['state'] =$tracking['state'];
                    $tealca['description'] =$tracking['description'];
                    $tealca['locationZone'] =$tracking['locationZone'];
                    $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));

                    // $sumando['Status'] ='RECEPTADO A BODEGA';
                    // $sumando['description'] =$tracking['description'];
                    // $sumando['city'] =$tracking['city'];
                    // $sumando['state'] =$tracking['state'];
                    // $sumando['description'] =$tracking['description'];
                    // $sumando['locationZone'] =$tracking['locationZone'];
                    // $sumando['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                    // $order1->historical[]= $sumando;

                    $order1->historical[]= $tealca;
                    $info_tealca[] = $order1;
                    break;

                case 'Recepcion desde plataforma':
                    $tealca['Status']  = 'RECEPTADO A BODEGA';
                    $tealca['description'] =$tracking['description'];
                    $tealca['city'] =$tracking['city'];
                    $tealca['state'] =$tracking['state'];
                    $tealca['description'] =$tracking['description'];
                    $tealca['locationZone'] =$tracking['locationZone'];
                    $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                    $order1->historical[]= $tealca;
                    $info_tealca[] = $order1;
                    break;

                case 'Recepcion desde tienda':
                    $tealca['Status']  = 'RECEPCION EN SUCURSAL';
                    $tealca['description'] =$tracking['description'];
                    $tealca['city'] =$tracking['city'];
                    $tealca['state'] =$tracking['state'];
                    $tealca['description'] =$tracking['description'];
                    $tealca['locationZone'] =$tracking['locationZone'];
                    $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                    $order1->historical[]= $tealca;
                    $info_tealca[] = $order1;
                    break;

                case 'Despacho a tienda(tienda destino para entrega al cliente)':
                    $tealca['Status']  = 'DESPACHO A SUCURSAL';
                    $tealca['description'] =$tracking['description'];
                    $tealca['city'] =$tracking['city'];
                    $tealca['state'] =$tracking['state'];
                    $tealca['description'] =$tracking['description'];
                    $tealca['locationZone'] =$tracking['locationZone'];
                    $tealca['date'] =date('Y/m/d H:i:s', strtotime($tracking['date']));
                    $order1->historical[]= $tealca;
                    $info_tealca[] = $order1;
                    break;
            }
        }
    }
}
        return response()->json($query[0]);

    }

    public function store(Request $request)
    {
        try {

            // $validator = $this->GuideValidate($request);

            $validator = Validator::make(
                $request->all(),
                [
                    // 'order_id' => [$action == 'create' ? 'confirmed' : 'nullable',
                    //         Rule::requiredIf($action == 'create'), 'exists:orders,id'
                    // ],
                    'order_id' => 'nullable',
                    'branch_office' => 'nullable',
                    'transport_type' => 'nullable',
                    'dispatched' => 'nullable',
                    'address_id' => 'nullable',
                    'address_name' => 'required|string|max:200',
                    'address_lat' => 'nullable',
                    'address_lng' => 'nullable',
                    'address_description' => 'nullable',
                    'zone' => 'nullable',
                    'country' => 'required|string|size:2',
                    'city' => 'required|string|size:3',
                    'recipient_name' => 'required|string|max:100',
                    'document_type' => 'required|string',
                    'document' => 'required|numeric|digits_between:1,15',
                    'delivery_office' => 'required|string|max:100',
                    'pre_guide' => 'required|numeric|digits_between:1,20',
                    'invoice_number' => 'required|alpha_num',
                    'declared' => 'required|numeric',
                    'pieces' => 'required|numeric',
                    'kg' => 'required|numeric',
                    'concept' => 'nullable',
                    'rate' => 'nullable',
                    'value' => 'nullable',
                    'corp_value' => 'nullable',
                    'customer_document_type' => 'nullable',
                    'contact' => 'required|string|max:20',
                    'phone_contact' => 'required|numeric|digits_between:1,11',
                    'email_contact' => 'required|email|max:75',
                    'invoice_contact' => 'nullable',
                    'same_day_delivery' => 'nullable',
                    'sign' => 'nullable',
                    'take_photo' => 'nullable',
                    'packaging' => 'nullable',
                    'return_last_destination' => 'nullable',
                    'description' => 'nullable|max:150',

                    //EMPTY TEALCA FIELDS
                    'UserLogin' => 'required|string',
                    'DeclaratedValueCurrency' => 'required|string|max:3',
                    'DeclaratedValueInvoceNum' => 'nullable|string|max:20',
                    'IsSafeKeeping' => 'required',
                    'CustomerCode' => 'required|string|max:10',
                    'BUCodeSource' => 'required|string|max:3',
                    'BUCodeConsignee' => 'nullable|string|max:3',
                    // 'ConsigneeCountry' => 'required|string|size:2',
                    'ConsigneePhoneCode' => 'required|numeric|digits_between:1,3',
                    'EmailType' => 'required|numeric|size:020',
                    'ConsigneeTaxIdentTypeCode' => 'required|string|max:10',
                    'ShipperCountry' => 'required|string|size:2',
                    'ShipperCity' => 'required|string|size:3',
                    'ShipperAddress' => 'required|string|max:200',
                    'ShippingMethodID' => 'required|numeric|size:10',
                    'ShipperIdentification' => 'required|numeric|digits_between:1,15',
                    'ShipperName' => 'required|max:100',
                    'ShipperPhoneCode' => 'required|numeric|digits_between:1,3',
                    'ShipperPhone' => 'required|numeric|digits_between:1,11',
                    'ShipperTaxIdentTypeCode' => 'required|max:10',
                    'DeliveryTypeID' => 'required|numeric|size:10',
                    'MeasureUnitTypeID' => 'required|numeric',
                    'WeightUnitID' => 'required|numeric',
                    'PackageTypeID' => 'required|numeric|size:10',
                    'ShipperPostalCode' => 'required|string|max:12',
                    'ShipperAddressLine2' => 'nullable',
                    'ConsigneePostalCode' => 'nullable|numeric|digits_between:1,12',
                    'ConsigneeAddressLine2' => 'nullable|string|max:200',
                    'ShipmentDetailReference' => 'nullable|string|max:100',
                    'ProductCode' => 'nullable|string|max:250',
                    'Lenght' => 'nullable|numeric',
                    'Width' => 'nullable|numeric',
                    'Height' => 'nullable|numeric',
                    'ConsigneeEmail' => 'required|email|max:75',
                ]
            );


            if ($validator->fails()) {
                return $this->respond(400, null, $validator->errors(), "Solicitud incorrecta");
            }

            $user_id = $request->user_id;
            $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
            $order = Order::where('order_type', $order_type)->latest()->first(['id', 'order_number']);
            $lot_number = 'Lote_1';
            if (!is_null($order)) {
                $last_batch = explode('_', $order->order_number)[1];
                $lot_number = 'Lote_' . ($last_batch + 1);
            }

            DB::beginTransaction();
            $orderResponse = $this->storeOrder(new Request(array(
                'user_id' => Auth::user()->id,
                'guides' => json_decode($request->guides),
                'order_number' => $lot_number,
                'order_type' => $order_type,
                'creator_user_id' => Auth::user()->id,
            )));

            $order_id = $orderResponse['data']['id'];

            $Order = Guide::create([
                'order_id' => $order_id,
                'description' => $request->description,
                'branch_office' => $request->branch_office,
                'transport_type' => $request->transport_type,
                'dispatched' => $request->dispatched,
                "address_id" => $request->address_id,
                'address_name' => $request->address_name,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
                'address_description' => $request->address_description,
                'detail_package' => $request->detail_package,
                'zone' => $request->zone,
                'country' => $request->country,
                'city' => $request->city,
                'recipient_name' => $request->recipient_name,
                'document_type' => $request->document_type,
                'document' => $request->document,
                'delivery_office' => $request->delivery_office,
                'pre_guide' => $request->pre_guide,
                'invoice_number' => $request->invoice_number,
                'declared' => $request->declared,
                'pieces' => $request->pieces,
                'kg' => $request->kg,
                'concept' => $request->concept,
                'rate' => $request->rate,
                'value' => $request->value,
                'corp_value' => $request->corp_value,
                'customer_document_type' => $request->customer_document_type,
                'contact' => $request->contact,
                'phone_contact' => $request->phone_contact,
                'email_contact' => $request->email_contact,
                'invoice_contact' => $request->invoice_contact,
                'same_day_delivery' => $request->same_day_delivery,
                'sign' => $request->sign,
                'take_photo' => $request->take_photo,
                'packaging' => $request->packaging,
                'return_last_destination' => $request->return_last_destination,
                'boxes' => $request->boxes
            ]);
            DB::commit();

            $Guide = new Guide();
            $Tealca = new Tealca();
            $Tealca->login();
            $guideResponse = $Guide->getGuidesByOrder($order_id, false);
            if ($guideResponse['state'] != 200) {
                return $guideResponse;
            }
            $guides = $guideResponse['data'];
            foreach ($guides as $guide) {
                if ($guide->external_id != NULL) {
                    continue;
                }
                $response = $Tealca->requestCreateShipment($guide);
                if ($response['state'] == 200) {
                    return $this->respond(200, $response['data'], null, 'OK');
                }
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $request->merge(['order_id' => $id]);
            return $orderResponse = $this->updateOrder($request);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
        }
    }

    public function export2(Request $request){

        // $id_user = $request['user']['grl_persona_id'];
        $fecha_begin = date('Y-m-d 00:00:00', ((int)$request->begin / 1000));
        $fecha_end = date('Y-m-d 23:59:59', ((int)$request->end / 1000));

        return Excel::download(new OrdersExportServices($fecha_begin,$fecha_end), 'prueba.xls');
      }


}
