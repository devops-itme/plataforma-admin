<?php

namespace App\Modules\OrderModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;
use App\Http\Resources\OrderResource;
use App\Modules\AddressModule\Address;
use App\Modules\AddressModule\Controllers\AddressTrait;
use App\Modules\GuidanceDocumentModule\Controllers\GuidanceDocsTrait;
use App\Modules\GuideModule\Controllers\GuideTrait;
use App\Modules\OrderModule\Controllers\OrderTrait;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RateModule\Rate;
use App\Modules\StatusMatrixModule\StatusMatrix;
use App\Modules\GuidanceDocumentModule\Controllers\Api\GuidanceDocumentController;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\GuideLogModule\GuideLog;
use App\Modules\RouteModule\Route;
use App\Modules\ZoneModule\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Log;

class OrderController extends Controller
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
        $user_id = $request->user_id ?? Auth::user()->id;
        $role_name = $request->role_name ?? Auth::user()->getRole->name;
        $scope_name = $request->scope_name ?? [];
        $status_matrix = $request->status_matrix ?? [];
        $orders = [];

        try {
            $status_matrix = StatusMatrix::whereIn('name', $status_matrix)->get(['id']);
            count($status_matrix) == 0 && $status_matrix = null;

            $scopes = ParameterValue::whereIn('name', $scope_name)->get(['id']);
            $status = StatusMatrix::whereIn('scope_id', $scopes)->get(['id']);
            count($status) == 0 && $status = null;

            if ($role_name == 'Cliente') {
                $orders = Order::where('user_id', $user_id)
                    ->whereStatusMatrix($status)
                    ->whereStatusMatrix($status_matrix)
                    ->with($this->customerRelationships)->get();
            }

            if ($role_name == 'Mensajero') {
                $orders = Order::messengerOrders($user_id)
                    ->whereStatusMatrix($status)
                    ->whereStatusMatrix($status_matrix)
                    ->with($this->messengerRelationships)->get();
            }

            $orders = OrderResource::collection($orders);
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function show($order_id)
    {
        try {
            $order = Order::find($order_id);
            $order = OrderResource::collection([$order])[0];
            return $this->respond(200, $order, null, 'Detalle de la orden');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function store(Request $request)
    {
        try {
            if (Auth()->user()->role != 1) {
                $request->merge(['user_id' => Auth()->user()->id]);
            };

            $last_id = Order::all()->where('external_id', NULL)->last()->id ?? 0;
            $request->merge(['order_number' => 'Orden_' . ($last_id + 1)]);

            $transactionResponse = DB::transaction(function () use ($request) {
                $Rate = new Rate();
                $source_zone_id = $request->zone_id;
                $rate = Rate::where('zone_id', $source_zone_id)->whereHas('getPackageType', function ($query) {
                    $query->where('name', 'Tipo A');
                })->first();

                if (is_null($rate)) {
                    return $this->respond(404, $request->all(), 'not found', 'No existen tarifas para esta orden');
                }

                $source_rate = $Rate->calculateRate($rate->id);

                $user_id = Auth::user()->id;
                $request->merge(['user_id' => $user_id, 'description' => $request->address_description]);

                if (!is_null($request->address_id)) {
                    $address = Address::find($request->address_id);
                    if (is_null($address)) {
                        return $this->respond(500, null, 'not found', 'Dirección no encontrada');
                    }
                } else if ((bool)$request->add_address_favorite) {
                    $saveAddressResponse = $this->saveAddress($request);
                    if ($saveAddressResponse['state'] != 200) {
                        return $saveAddressResponse;
                    }
                    $address_id = $saveAddressResponse['data']->id ?? '';
                    $request->merge(['address_id' => $address_id]);
                } else {
                    $validator = $this->AddressesValidate($request);
                    if ($validator->fails()) {
                        return $this->respond(500, [],  $validator->errors() . ' - address',  $validator->errors()->first());
                    }
                }

                $request->merge(['description' => $request->order_description]);

                $storeOderResponse = $this->storeOrder($request);
                if ($storeOderResponse['state'] != 200) {
                    return $storeOderResponse;
                }

                $order_id = $storeOderResponse['data']->id;

                $guides = $request->guides;
                // $guides = json_decode($guides, true);

                $rate_value = 0;
                foreach ($guides as $guide) {
                    $guide = json_decode($guide, true);

                    $address = null;
                    if ($guide['address_id'] != '') {
                        $address = Address::find($guide['address_id']);
                        if (is_null($address)) {
                            return $this->respond(500, null, 'not found', 'Dirección no encontrada');
                        }
                    }
                    $destination_zone_id = $guide['zone_id'];
                    $rate = Rate::where('zone_id', $destination_zone_id)->whereHas('getPackageType', function ($query) {
                        $query->where('name', 'Tipo A');
                    })->first();

                    if (is_null($rate)) {
                        return $this->respond(404,  $destination_zone_id, 'not found', 'No existen tarifas para esta orden');
                    }
                    $destination_rate = $Rate->calculateRate($rate->id);

                    $rate_value = $rate_value + ($source_rate > $destination_rate ? $source_rate : $destination_rate);

                    $tax_percentage = 7;
                    $tax_value = $rate_value * ($tax_percentage / 100);
                    $rate_value_total = $rate_value + $tax_value;

                    $request->merge([
                        'order_id' => $order_id,
                        'guide_description' => $guide['guide_description'],
                        'contact' => $guide['contact'],
                        'phone_contact' => $guide['phone_contact'],
                        'email_contact' => $guide['email_contact'] ?? '',
                        'return_last_destination' => $guide['return_last_destination'],
                        'address_name' => $address->name ?? $guide['address'],
                        'address_lat' => $address->lat ?? $guide['lat'],
                        'address_lng' => $address->lng ?? $guide['lng'],
                        'address_description' => $address->description ?? $guide['address_description'],
                        'description' => $guide['guide_description'],
                        "transport_type" => $guide['transport_type'] ?? '',
                        'state' => 31,
                        'detail_package' => $guide['detail_package'] ?? '',
                    ]);
                    $request->description = $guide['guide_description'];
                    $request_address = new Request(array(
                        'user_id' => $user_id,
                        'address' => $request->address_name,
                        'name' => $request->address_name,
                        'description' => $request->address_description,
                        'lat' => $request->address_lat,
                        'lng' => $request->address_lng,
                    ));

                    if (is_null($guide['address_id'])) {
                        $validator = $this->AddressesValidate($request_address);

                        if ($validator->fails()) {
                            return $this->respond(500, [],  $validator->errors() . ' - address',  $validator->errors()->first());
                        }
                    }
                    if ((bool)$guide['add_address_favorite'] && (is_null($guide['address_id']) || $guide['address_id'] == "")) {
                        $saveAddressResponse = $this->saveAddress($request_address);
                        if ($saveAddressResponse['state'] != 200) {
                            return $saveAddressResponse;
                        }
                    }
                    $storeGuideResponse = $this->storeGuide($request);
                    if ($storeGuideResponse['state'] != 200) {
                        return $storeGuideResponse;
                    }
                    
                    $guide_id = $storeGuideResponse['data']->id;
                    $guidance_document_ids = $guide['guidance_document_ids'];

                    if ($guidance_document_ids) {
                        $GuidanceDocument = new GuidanceDocument();
                        $response = $GuidanceDocument->associateGuideDocuments($guide_id, $guidance_document_ids);
                        if ($response['state'] != 200) {
                            return $response;
                        }
                    }
                }

                $order = Order::find($order_id);
                $order->update(['order_value' => $rate_value_total, 'tax_total' => $tax_value]);
                
                return $this->respond(200, $order, null, 'Orden creada correctamente');
            });
            return $transactionResponse;
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

    public function markAsRead(Request $request)
    {
        try {
            $order = Order::where('id', $request->order_id)->first();

            if (is_null($order)) {
                return $this->respond(500, null, 'not found', 'No se encontró la orden');
            }
            $updates = ['app_status' => 1];
            if ($order->update($updates)) {
                $order = $order->with($this->messengerRelationships)->get();
                $order = OrderResource::collection($order)[0];
                return $this->respond(200, $order, null, 'Ordenes marcada como leída');
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $order = Order::where('id', $request->order_id)->first();
            if (is_null($order)) {
                return $this->respond(500, null, 'not found', 'No se encontró la orden');
            }
            if ($order->update($request->all())) {
                $order = $order->load($this->messengerRelationships);
                $order = OrderResource::collection([$order])[0];
                return $this->respond(200, $order, null, 'Haz culminado esta orden');
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function webviewPagueloFacil(Request $request)
    {
        $host = $request->getHost();
        $fcm_token = $request->fcm_token;
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $confirmationUrl = "http://" . $host . "/api/order/webview/paguelo-facil/response?fcm_token=" . $fcm_token . "&order_id=" . $order_id;
        $cclw = env('PAGUELOFACIL_CCLW');
        $amount = (float) $order->order_value;
        $description = 'Pago orden multientrega';
        $data = array(
            "CCLW" => $cclw,
            "CMTN" => $amount,
            "CDSC" => $description,
            "RETURN_URL" => $confirmationUrl,
            "PF_CF" => '5B7B226964223A227472616D6974654964222C226E616D654F724C6162656C223A2249642064656C205472616D697465222C2276616C7565223A2254494432333435227D5D',
            "payment_type" => '',
        );
        $postR = "";
        $sw = 0;
        foreach ($data as $mk => $mv) {
            if ($sw == 0) {
                $postR = "?" . $mk . "=" . $mv;
                $sw = 1;
                continue;
            }
            $postR .= "&" . $mk . "=" . $mv;
        }

        $sendOrder = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => '*/*',
        ])->post(env('PAGUELOFACIL_URL') . $postR);
        $response = $sendOrder->json();

        $total = $order->order_value;

        return view('OrderModule.views.html.webview.paguelofacil', compact('response', 'total'));
    }

    public function responseViewPagueloFacil(Request $request)
    {
        $response = $request->all();
        if ($response['Estado'] != 'Denegada') {
            $order = Order::find($request->order_id);
            $order->update(['paid' => 1]);
        }
        $response['order_id'] = $request->order_id;
        $response['fcm_token'] = $response['fcm_token'] ?? Auth::user()->fcm_token;
        return view('OrderModule.views.html.webview.paguelofacil', compact('response'));
    }

    public function sendPushNotification(Request $request)
    {
        try {
            $userToken = $request->fcm_token;
            $data = $request->all();

            return sendCustomNotifications('Multientrega', 'Pasarela de pago', $data, $userToken);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function CourierOrderHistory(Request $request)
    {
        try {
            $state = $request->state;

            $state == 'record' ? $state = [6, 10] : ($state == 'active' ?  $state = [4, 5, 8, 9] : $state = [intval($state)]);

            $guide_pickup = [];
            $GuideLog_pickup = GuideLog::with(
                [
                    'getState',
                    'getIssue',
                ]
            )->whereHas('getState', function ($query) {
                $query->whereHas('getScope', function ($query) {
                    $query->where('name', 'pickup');
                });
            })->orderBy('created_at', 'ASC')->get();

            foreach ($GuideLog_pickup as $key => $item) {
                array_push($guide_pickup, $item);
            }
            $guide_pickup_new = array_values(array_column($guide_pickup, null, "guide_id"));

            $guides_pickup_arr = collect($guide_pickup_new)->map(function ($item) use ($GuideLog_pickup) {
                $data_guide_log = $GuideLog_pickup->where('guide_id', $item->getGuide->id)->first();
                $data_guide_log2 = $GuideLog_pickup->where('guide_id', $item->getGuide->id)->last();
                $item->getGuide->status_matrix_id = $item->status_matrix_id;
                
                if ($data_guide_log) {
                    $documents = GuidanceDocument::where('guide_id', $item->getGuide->id)->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->get();
                    $route = Route::where('guide_id', $item->getGuide->id)->with('getMessenger.getMessenger')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->first();
                    $Issue = GuideLog::where('guide_id', $item->getGuide->id)->where('issue_id','<>',null)->with('getIssue')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->get();
                    $status_matrix = StatusMatrix::find($item->status_matrix_id);
                    $item->getGuide->getRoute = $route;
                    $item->getGuide->getStatusMatrix = $status_matrix;
                    if(isset($Issue[0])){
                        $item->getGuide->novelty = json_decode($Issue[0]->url_document)->novelty ?? '';
                        $item->getGuide->recipient_name =  json_decode($Issue[0]->url_document)->recipient_name ?? '';
                        $item->getGuide->additional_phone =  json_decode($Issue[0]->url_document)->additional_phone ?? '';
                        $item->getGuide->additional_email =  json_decode($Issue[0]->url_document)->additional_email ?? '';
                        $item->getGuide->additional_address =  json_decode($Issue[0]->url_document)->additional_address ?? '';
                    }
                }
                return $item->getGuide;
            });

            $guide_delivery = [];
            $GuideLog_delivery = GuideLog::with(
                [
                    'getState',
                    'getIssue',
                ]
            )->whereHas('getState', function ($query) {
                $query->whereHas('getScope', function ($query) {
                    $query->where('name', 'delivery');
                });
            })->orderBy('created_at', 'ASC')->get();
            
            foreach ($GuideLog_delivery as $key => $item) {
                array_push($guide_delivery, $item);
            }

            $guide_delivery_new = array_values(array_column($guide_delivery, null, "guide_id"));

            $guides_delivery_arr = collect($guide_delivery_new)->map(function ($item) use ($GuideLog_delivery) {
                $data_guide_log = $GuideLog_delivery->where('guide_id', $item->getGuide->id)->first();
                $data_guide_log2 = $GuideLog_delivery->where('guide_id', $item->getGuide->id)->last();
                $item->getGuide->status_matrix_id = $item->status_matrix_id;
                if ($data_guide_log) {
                    $documents = GuidanceDocument::where('guide_id', $item->getGuide->id)->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->get();
                    $route = Route::where('guide_id', $item->getGuide->id)->with('getMessenger.getMessenger')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->first();
                    $Issue = GuideLog::where('guide_id', $item->getGuide->id)->where('issue_id','<>',null)->with('getIssue')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->get();
                    $status_matrix = StatusMatrix::find($item->status_matrix_id);
                    $item->getGuide->getRoute = $route;
                    $item->getGuide->getStatusMatrix = $status_matrix;
                    $item->getGuide->getIssues = $Issue;
                    if(isset($Issue[0])){
                        $item->getGuide->novelty = json_decode($Issue[0]->url_document)->novelty ?? '';
                        $item->getGuide->recipient_name =  json_decode($Issue[0]->url_document)->recipient_name ?? '';
                        $item->getGuide->additional_phone =  json_decode($Issue[0]->url_document)->additional_phone ?? '';
                        $item->getGuide->additional_email =  json_decode($Issue[0]->url_document)->additional_email ?? '';
                        $item->getGuide->additional_address =  json_decode($Issue[0]->url_document)->additional_address ?? '';
                    }
                }
                return $item->getGuide;
            });

            $new_guides = $guides_delivery_arr->merge($guides_pickup_arr);
            $guides = $new_guides->whereIn('status_matrix_id', $state);

            $guide_arr = [];
            foreach ($guides as $item) {
                if ($item->getRoute) {
                    $item->getRoute->messenger_user_id == Auth()->user()->id ? array_push($guide_arr, $item) : '';
                }
            }

            //if request order id return guides by
            if ($request->order_id) {
                $guides_list = collect($guide_arr)->whereIn('order_id', $request->order_id);
                $data = GuideResource::collection($guides_list);
                dd(gettype($data));
                return $this->respond(200, $data, null, 'Guías');
            }

            $guides_arr_ids = collect($guide_arr)->map(function ($item) {
                return $item->order_id;
            });

            $data = Order::whereIn('id', $guides_arr_ids)->with($this->messengerRelationships)->get();

            $orders = OrderResource::collection($data);
            return $this->respond(200, $orders, null, 'Historial ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
