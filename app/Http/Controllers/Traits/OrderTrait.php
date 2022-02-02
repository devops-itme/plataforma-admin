<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Order;

trait OrderTrait
{
    use RestActions;

    public function OrderValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'user_id ' => 'required|exists:users,id',
                'service_type_id ' => 'required',
                'state' => 'required'
            ]
        );
    }

    public function storeOrder($request)
    {
        $validator = $this->OrderValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }
        try {
            $order = Order::create([
                'user_id' => $request->user_id,
                'service_type' => $request->service_type,
                'state' => $request->state
            ]);
            return $this->respond(200, $order, null, 'Orden creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear orden');
        }
    }

    public function updateOrder($request)
    {
        $validator = $this->OrderValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $order = Order::find($request->order_id);
            if (is_null($order)) {
                return $this->respond(500, [], 'user not found', 'No se encontro la orden');
            }
            $order->update([
                'service_type_id ' => $request->service_type_id,
                'state' => $request->state
            ]);
            return $this->respond(200, $order, null, 'Oficina actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar orden');
        }
    }

    public function deleteOrder($request)
    {
        try {
            $order = Order::find($request->order_id);
            if (is_null($order)) {
                return $this->respond(500, [], 'user not found', 'No se encontro la orden');
            }
            $order->delete();
            return $this->respond(200, $order, null, 'Orden eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar usuario');
        }
    }
}
