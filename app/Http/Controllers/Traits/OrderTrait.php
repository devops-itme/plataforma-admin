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
                    Rule::requiredIf($action == 'create'), 'unique:orders,order_number,'.$id],
                'user_id' => 'required|exists:users,id',
                'order_type' => 'required',
                'order_value' => 'required',
                'receive_by_COD' => 'required',
                'internal_product' => 'required',
                'expenses' => 'required',
                'diligence_expenses' => 'required',
                'tax_total' => 'required',
                'payment_method' => 'required',
                'urgent_dispatch' => 'required',
                'return_last_destination' => 'required',
                'schedule_date' => 'required',
                'schedule_time' => 'required',
                'insured_value' => 'nullable',
                'money_to_collect' => 'nullable',
                'percentage_to_collect' => 'nullable',
                'branch_office' => 'nullable',
                'department_id' => 'nullable',
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
                'return_last_destination' => $request->return_last_destination,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect,
                'customer_user_id' => $request->user_id,
                'branch_office' => $request->branch_office_id,
                'department_id' => $request->department_id,
                'status_matrix_id' => $status_id,
            ]);
            return $this->respond(200, $order, null, 'Orden creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear orden');
        }
    }

    public function updateOrder($request)
    {
        $validator = $this->OrderValidate($request, null ,$request->order_id);
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
                'return_last_destination' => $request->return_last_destination,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect,
                'customer_user_id' => $request->user_id,
                'branch_office' => $request->branch_office_id,
                'department_id' => $request->department_id
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
            foreach($request->guideCheck as $key){
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
