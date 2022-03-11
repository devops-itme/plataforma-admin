<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DeliveryTrait;
use App\Http\Controllers\Traits\RouteTrait;
use App\Order;
use App\ParameterValue;
use App\StatusDescriptor;
use App\StatusMatrix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    use RouteTrait;

    public function indexOndemand()
    {
        return view('deliveries.index');
    }

    public function indexPacking()
    {
        return view('deliveriesPacking.index');
    }

    public function assignOndemad(Request $request)
    {
        $response = $this->storeRouteOndemand($request);

        if ($response['state'] == 200) {
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

    public function assignPacking(Request $request)
    {
        $response = $this->storeRoutePacking($request);

        if ($response['state'] == 200) {
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

    public function orderStates()
    {
        $order_states = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_states');
        })->get();
        return $this->respond(200, $order_states, null, 'Estado de las ordenes');
    }

    public function updateStateOrders($state, Request $request)
    {
        $order = Order::where('id', $request->order_id)->update([
            'state' => $state
        ]);
        return $this->respond(200, $order, null, 'estado actualizado');
    }

    public function statusMatrix()
    {
        $role_id = 1;
        $statusMatrix = StatusMatrix::get();

        $data = $statusMatrix->map(function ($item, $key) use ($role_id) {
            $descriptor = StatusDescriptor::where('status_matrix_id', $item->id)->where('role_id', $role_id)->first();
            if (!is_null($descriptor)) {
                $item->name = $descriptor->description;
            }
            return $item;

        });

        return $this->respond(200, $data, null, 'matriz de estados');
    }
}
