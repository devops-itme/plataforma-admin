<?php

namespace App\Modules\OrderModule\Controllers\Api;

use App\Http\Controllers\Controller;

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
use App\Modules\ZoneModule\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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

            $last_id = Order::all()->last()->id ?? 0;
            $request->merge(['order_number' => 'Orden_' . ($last_id + 1)]);

            $transactionResponse = DB::transaction(function () use ($request) {
                $Rate = new Rate();
                $source_zone_id = $request->zone_id;
                $rate = Rate::where('zone_id', $source_zone_id)->whereHas('getPackageType', function ($query) {
                    $query->where('name', 'Tipo A');
                })->first();
                
                if (is_null($rate)) {
                    return $this->respond(404, null, 'not found', 'No existen tarifas para esta orden');
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

                $rate_value = 0;

                foreach ($guides as $guide) {
                    $address = null;
                    if (!is_null($guide['address_id'])) {
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
                        return $this->respond(404, null, 'not found', 'No existen tarifas para esta orden');
                    }
                    $destination_rate = $Rate->calculateRate($rate->id);

                    $rate_value = $rate_value + ($source_rate > $destination_rate ? $source_rate : $destination_rate);

                    $request->merge([
                        'order_id' => $order_id,
                        'guide_description' => $guide['guide_description'],
                        'contact' => $guide['contact'],
                        'phone_contact' => $guide['phone_contact'],
                        'email_contact' => $guide['email_contact'],
                        'return_last_destination' => $guide['return_last_destination'],
                        'address_name' => $address->name ?? $guide['address'],
                        'address_lat' => $address->lat ?? $guide['lat'],
                        'address_lng' => $address->lng ?? $guide['lng'],
                        'address_description' => $address->description ?? $guide['address_description'],
                        'description' => $address->description ?? $guide['address_description'],
                        "transport_type" => $guide['transport_type'] ?? '',
                        'state' => 31
                    ]);

                    if (is_null($guide['address_id'])) {
                        $validator = $this->AddressesValidate($request);

                        if ($validator->fails()) {
                            return $this->respond(500, [],  $validator->errors() . ' - address',  $validator->errors()->first());
                        }
                    }

                    if ((bool)$guide['add_address_favorite'] && is_null($guide['address_id'])) {
                        $saveAddressResponse = $this->saveAddress($request);
                        if ($saveAddressResponse['state'] != 200) {
                            return $saveAddressResponse;
                        }
                    }

                    $storeGuideResponse = $this->storeGuide($request);
                    if ($storeGuideResponse['state'] != 200) {
                        return $storeGuideResponse;
                    }
                }
                $order = Order::find($order_id);
                $order->update(['order_value' => $rate_value,]);

                return $this->respond(200, $order, null, 'Orden creada correctamente');
            });
            return $transactionResponse;
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
                $order = $order->with($this->messengerRelationships)->get();
                $order = OrderResource::collection($order);
                return $this->respond(200, $order, null, 'Haz culminado esta orden');
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function webviewPagueloFacil(Request $request)
    {

        $host = $request->getHost();
        $confirmationUrl = "http://" . $host . "/api/order/webview/paguelo-facil/response";
        $cclw = env('PAGUELOFACIL_CCLW');
        $amount = intval($request->totalValue);
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

        $total = $request->totalValue;


        return view('OrderModule.views.html.webview.paguelofacil', compact('response', 'total'));
    }

    public function responseViewPagueloFacil(Request $request)
    {

        $response = $request->all();
        $response['fcm_token'] = Auth::user()->fcm_token ?? 'cIf9y81ERbKO8AIc6YVgIv:APA91bEl-srTK43xGrQZCyfh3G2GFH62jNNnH48vQf6UaqJWNNxgkz-GvYCiXAADKEy-mmG5-vxeZtM7m8sMgbVg_oNjnHmqoy3mYW5y3FCvAf2vwWgLx1N6F9LGFgtuDjeLPHmPeaJS';

        return view('OrderModule.views.html.webview.paguelofacil', compact('response'));
    }
}
