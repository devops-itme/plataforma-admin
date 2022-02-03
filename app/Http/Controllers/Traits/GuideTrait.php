<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Guide;
use Illuminate\Validation\Rule;

trait GuideTrait
{
    use RestActions;

    public function GuideValidate($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'order_id' => [$action == 'create' ? 'confirmed' : 'nullable',
                        Rule::requiredIf($action == 'create'), 'exists:orders,id'
                ],
                'address_id' => 'required|exists:addresses,id',
                'delivery_date' => 'nullable|date',
                'shipping_cost' => 'nullable'
            ]
        );
    }

    public function storeGuide($request)
    {
        $validator = $this->GuideValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }
        try {
            $order = Guide::create([
                'order_id' => $request->order_id,
                'address_id' => $request->address_id,
                'delivery_date' => $request->delivery_date,
                'shipping_cost' => $request->shipping_cost
            ]);
            return $this->respond(200, $order, null, 'Guia creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear guia');
        }
    }

    public function updateGuide($request)
    {
        $validator = $this->GuideValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $guide = Guide::find($request->guide_id);
            if (is_null($guide)) {
                return $this->respond(500, [], 'user not found', 'No se encontro la guia');
            }
            $guide->update([
                'address_id' => $request->address_id,
                'delivery_date' => $request->delivery_date,
                'shipping_cost' => $request->shipping_cost
            ]);
            return $this->respond(200, $guide, null, 'Guia actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar guia');
        }
    }

    public function deleteGuide($id)
    {
        try {
            $guide = Guide::find($id);
            if (is_null($guide)) {
                return $this->respond(500, [], 'user not found', 'No se encontro la guia');
            }
            $guide->delete();
            return $this->respond(200, $guide, null, 'Guia eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar guia');
        }
    }
}
