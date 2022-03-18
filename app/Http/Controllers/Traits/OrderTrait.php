<?php

namespace App\Http\Controllers\Traits;

use App\Guide;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Order;
use App\StatusMatrix;
use Illuminate\Validation\Rule;

trait OrderTrait
{
    use RestActions;

    public function OrderValidate($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'order_number' => [$action == 'create' ? 'confirmed' : 'nullable',
                    Rule::requiredIf($action == 'create'), Rule::unique('orders', 'order_number')->ignore($id), 'string'],
                'user_id' => 'required|exists:users,id | numeric',
                'order_type' => 'required | numeric',
                'order_value' => 'nullable | numeric',
                'receive_by_COD' => 'nullable | numeric',
                'internal_product' => 'nullable | numeric',
                'expenses' => 'nullable | numeric',
                'diligence_expenses' => 'nullable | numeric',
                'tax_total' => 'nullable | numeric',
                'payment_method' => 'nullable | numeric',
                'urgent_dispatch' => 'nullable | numeric',
                'schedule_date' => 'required | regex:/(\d+\:\d+)/',
                'schedule_time' => 'required | numeric | exists:pickup_hours,id',
                'schedule_time_range' => 'required | string',
                'insured_value' => 'nullable | numeric',
                'money_to_collect' => 'nullable | numeric',
                'percentage_to_collect' => 'nullable | numeric',
                'branch_office' => 'nullable | numeric | exists:branch_offices,id',
                'department_id' => 'nullable | numeric | exists:departments,id',
                'address_id' => 'nullable | numeric | exists:addresses,id',
                'description' => 'nullable | string',
                'state' => 'nullable | numeric'
            ]
        );
    }

    public function storeOrder($request)
    {
        $validator = $this->OrderValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        $status = StatusMatrix::get();
        $status_id = $status[0]->id;
        try {
            $order = Order::create([
                'order_number' => $request->order_number,
                'user_id' => $request->user_id,
                'order_type' => $request->order_type,
                'order_value' => $request->order_value,
                'receive_by_COD' => $request->receive_by_COD,
                'internal_product' => $request->internal_product,
                'expenses' => $request->expenses,
                'diligence_expenses' => $request->diligence_expenses,
                'tax_total' => $request->tax_total,
                'payment_method' => $request->payment_method,
                'urgent_dispatch' => $request->urgent_dispatch,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'schedule_time_range' => $request->schedule_time_range,
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect,
                'customer_user_id' => $request->user_id,
                'branch_office' => $request->branch_office_id,
                'address_id' => $request->address_id,
                'description' => $request->description,
                'department_id' => $request->department_id,
                'status_matrix_id' => $status_id,
                'creator_user_id' => $request->creator_user_id
            ]);
            return $this->respond(200, $order, null, 'Orden creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear orden');
        }
    }

    public function updateOrder($request)
    {
        $validator = $this->OrderValidate($request, null, $request->order_id);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $order = Order::find($request->order_id);
            if (is_null($order)) {
                return $this->respond(500, [], 'user not found', 'No se encontró la orden');
            }
            $order->update([
                'user_id' => $request->user_id,
                'order_type' => $request->order_type,
                'order_value' => $request->order_value,
                'receive_by_COD' => $request->receive_by_COD,
                'internal_product' => $request->internal_product,
                'expenses' => $request->expenses,
                'diligence_expenses' => $request->diligence_expenses,
                'tax_total' => $request->tax_total,
                'payment_method' => $request->payment_method,
                'urgent_dispatch' => $request->urgent_dispatch,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect,
                'customer_user_id' => $request->user_id,
                'branch_office' => $request->branch_office_id,
                'department_id' => $request->department_id,
                'address_id' => $request->address_id,
                'description' => $request->description
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
                return $this->respond(500, [], 'user not found', 'No se encontró la orden');
            }
            $order->delete();
            return $this->respond(200, $order, null, 'Orden eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar usuario');
        }
    }

    public function assignGuide($request, $id)
    {
        try {
            $orderGuides = Guide::where('order_id', $id)->get();
            foreach ($orderGuides as $key) {
                $key->order_id = NULL;
                $key->save();
            }
            foreach ($request->guideCheck as $key) {
                Guide::find($key)->update([
                    'order_id' => $id
                ]);
            }
            return $this->respond(200, [], null, 'Guiás asignadas de forma correcta');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al asignar la guiá');
        }
    }
}
