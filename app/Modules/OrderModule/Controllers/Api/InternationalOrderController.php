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
use App\Modules\GuidanceDocumentModule\Controllers\Api\GuidanceDocumentController;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\ZoneModule\Zone;
use App\Modules\GuideModule\Guide;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

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
        $role_name = $request->role_name ?? Auth::user()->getRole->name;
        $scope_name = $request->scope_name ?? [];
        $status_matrix = $request->status_matrix ?? [];
        $order_type = "International";
        $orders = [];

        try {
            $status_matrix = StatusMatrix::whereIn('name', $status_matrix)->get(['id']);
            count($status_matrix) == 0 && $status_matrix = null;

            $scopes = ParameterValue::whereIn('name', $scope_name)->get(['id']);
            $status = StatusMatrix::whereIn('scope_id', $scopes)->get(['id']);
            count($status) == 0 && $status = null;

            if ($role_name == 'Admin') {
                // $orders = Order::where('user_id', $user_id)
                $orders = Order::whereStatusMatrix($status_matrix)
                    ->where('user_id', $user_id)
                    ->whereStatusMatrix($status)
                    ->international($order_type)
                    ->with($this->customerRelationships)->get();
            }

            if ($role_name == 'Cliente') {
                // $orders = Order::where('user_id', $user_id)
                $orders = Order::whereStatusMatrix($status_matrix)
                    ->where('user_id', $user_id)
                    ->whereStatusMatrix($status)
                    ->international($order_type)
                    ->with($this->customerRelationships)->get();
            }

            $orders = OrderResource::collection($orders);
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function show($order_id)
    {
        $order_type = "International";
        try {
            $order = Order::find($order_id)->where('order_type', $order_type)->get();
            $order = OrderResource::collection([$order])[0];
            return $this->respond(200, $order, null, 'Detalle de la orden');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function store(Request $request)
    {
        try {

            $validator = $this->GuideValidate($request);
            if ($validator->fails()) {
                return $this->respond(400, null, $validator->errors(), "Verifique los campos");
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
                    return $this->respond(200, $response['data'], null, 'Orden internacional creada exitosamente');
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
}
