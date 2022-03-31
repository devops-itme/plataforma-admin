<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AddressTrait;
use App\Http\Controllers\Traits\GuideTrait;
use App\Http\Controllers\Traits\OrderTrait;
use App\Http\Resources\OrderResource;
use App\Order;
use App\ParameterValue;
use App\StatusMatrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $scope_name = $request->scope_name;
        $orders = [];

        try {
            $scope = ParameterValue::where('name', $scope_name)->first();

            $scope_id = $scope->id ?? null;
            $status = StatusMatrix::where('scope_id', $scope_id)->get(['id']);

            if ($role_name == 'Cliente') {
                $orders = Order::where('user_id', $user_id)
                    ->scope($status)
                    ->with($this->customerRelationships)->get();
            }

            if ($role_name == 'Mensajero') {
                $orders = Order::messengerOrders($user_id)
                    ->scope($status)
                    ->with($this->messengerRelationships)->get();
            }

            $orders = OrderResource::collection($orders);
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function store(Request $request)
    {
        if (Auth()->user()->role != 1) {
            $request->merge(['user_id' => Auth()->user()->id]);
        };

        $last_id = Order::all()->last()->id ?? 0;
        $request->merge(['order_number' => 'Orden_' . ($last_id + 1)]);

        try {
            $transactionResponse = DB::transaction(function () use ($request) {

                if (!is_null($request->address_id)) {
                    $address = Address::find($request->address_id);
                    if (is_null($address)) {
                        return $this->respond(500, null, 'not found', 'Dirección no encontrada');
                    }
                } else if ($request->add_address_favorite === 'true') {
                    $user_id = Auth::user()->id;
                    $request->merge(['user_id' => $user_id, 'description' => $request->address_description]);
                    $saveAddressResponse = $this->saveAddress($request);
                    if ($saveAddressResponse['state'] != 200) {
                        return $saveAddressResponse;
                    }
                } else {
                    $validator = $this->AddressesValidate($request);

                    if ($validator->fails()) {
                        return $this->respond(500, [],  $validator->errors(),  $validator->errors()->first());
                    }
                }

                $storeOderResponse = $this->storeOrder($request);
                if ($storeOderResponse['state'] != 200) {
                    return $storeOderResponse;
                }

                $order_id = $storeOderResponse['data']->id;

                $guides = $request->guides;

                foreach ($guides as $guide) {
                    $address;
                    if (!is_null($guide['address_id'])) {
                        $address = Address::find($guide['address_id']);
                        if (is_null($address)) {
                            return $this->respond(500, null, 'not found', 'Dirección no encontrada');
                        }
                    }

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
                        'state' => 31
                    ]);

                    $request->merge(['description' => $request->address_description]);
                    $validator = $this->AddressesValidate($request);

                    if ($validator->fails()) {
                        return $this->respond(500, [],  $validator->errors(),  $validator->errors()->first());
                    }

                    if ($guide['add_address_favorite'] === 'true') {
                        $user_id = Auth::user()->id;
                        $request->merge(['user_id' => $user_id]);
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
                return $this->respond(200, null, null, 'Orden creada correctamente');
            });
            return $transactionResponse;
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . $e->getLine(), 'Error del servidor');
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
}
