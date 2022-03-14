<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Guide;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GuideTrait;
use App\Http\Controllers\Traits\OrderTrait;
use App\Http\Resources\OrderResource;
use App\Order;
use App\ParameterValue;
use App\Route;
use App\StatusMatrix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use OrderTrait, GuideTrait;

    protected $customerRelationships = [
        'getOrderType', 'getDocumentType', 'getPaymentMethod',
        'getState', 'getDepartment', 'getBranchOffice'
    ];

    protected $messengerRelationships = [
        'getUser', 'getUser.getDocumentType',
        'getOrderType', 'getDocumentType', 'getPaymentMethod',
        'getState', 'getDepartment', 'getBranchOffice'
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

        $validator = $this->OrderValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }

        try {
            // DB::transaction(function () use ($request) {

            $storeOderResponse = $this->storeOrder($request);
            if ($storeOderResponse['state'] != 200) {
                return $storeOderResponse;
            }

            $order_id = $storeOderResponse['data']->id;

            $guides = $request->guides;
            $guides = (array) json_decode($guides, true);

            foreach ($guides as $guide) {

                $address = Address::find($guide['address_id']);
                if (is_null($address)) {
                    return $this->respond(500, null, 'not found', 'Dirección no encontrada');
                }

                $newGuide = Guide::create([
                    'order_id' => $order_id,
                    'guide_description' => $guide['guide_description'],
                    'contact' => $guide['contact'],
                    'phone_contact' => $guide['phone_contact'],
                    'email_contact' => $guide['email_contact'],
                    'return_last_destination' => $guide['return_last_destination'],
                    'address_name' => $address->name,
                    'address_lat' => $address->lat,
                    'address_lng' => $address->lng,
                    'address_description' => $address->description,
                    'state' => 31
                ]);

                if ($newGuide) {
                    return $this->respond(200, $newGuide, null, 'Guiá creada exitosamente');
                }
                // $validator = $this->GuideValidate($request);
                // if ($validator->fails()) {
                //     return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
                // }

                // $storeGuideResponse = $this->storeGuide($guide);
                // if ($storeGuideResponse['state'] != 200) {
                //     return $storeGuideResponse;
                // }
            }
            // });

            return $this->respond(200, null, null, 'Orden creada correctamente');
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
