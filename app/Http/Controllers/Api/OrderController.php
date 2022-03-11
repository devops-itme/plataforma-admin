<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\OrderTrait;
use App\Http\Resources\OrderResource;
use App\Order;
use App\ParameterValue;
use App\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use OrderTrait;

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
        $role = $request->role_id ?? Auth::user()->getRole;
        $state_name = $request->state_name;
        $orders = [];

        try {
            $state = ParameterValue::where('name', $state_name)->first();

            if ($role->name == 'Cliente') {
                $orders = Order::where('user_id', $user_id)
                    ->state($state->id ?? null)
                    ->with($this->customerRelationships)->get();
            }

            if ($role->name == 'Mensajero') {
                $orders = Order::messengerOrders($user_id)
                    ->state($state->id ?? null)
                    ->with($this->messengerRelationships)->get();
            }

            $orders = OrderResource::collection($orders);
            return $this->respond(200, $orders, null, 'Ordenes en ' . $state_name);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function store(Request $request)
    {
        if (Auth()->user()->role != 1) {
            $request->merge(['user_id' => Auth()->user()->id]);
        };
        return ($request->all());

        try {
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
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
