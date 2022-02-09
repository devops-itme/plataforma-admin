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
                'number' => 'required|unique:orders',
                'user_id' => 'required|exists:users,id',
                'service_type_id' => 'required',
                'vehicle_type_id' => 'required',
                'payment_method_id' => 'required',
                'schedule_date' => 'required',
                'schedule_time' => 'required',
                'express_delivery' => 'required',
                'last_destination_return' => 'required',
                'insured_value' => 'required',
                'percentage_receivable' => 'required',
                'value_receivable' => 'required',
                'state' => 'nullable'
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
                'number' => $request->number,
                'user_id' => $request->user_id,
                'service_type_id' => $request->service_type_id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'payment_method_id' => $request->payment_method_id,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'express_delivery' => $request->express_delivery,
                'last_destination_return' => $request->last_destination_return,
                'insured_value' => $request->insured_value,
                'percentage_receivable' => $request->percentage_receivable,
                'value_receivable' => $request->value_receivable,
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
                'service_type_id' => $request->service_type_id,
                'state' => $request->state
            ]);
            return $this->respond(200, $order, null, 'Orden actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar orden');
        }
    }

    public function deleteOrder($id)
    {
        try {
            $order = Order::find($id);
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
