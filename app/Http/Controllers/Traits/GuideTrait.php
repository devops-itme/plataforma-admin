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
                // 'order_id' => [$action == 'create' ? 'confirmed' : 'nullable',
                //         Rule::requiredIf($action == 'create'), 'exists:orders,id'
                // ],
                'order_id' => 'nullable',
                'branch_office' => 'nullable',
                'transport_type' => 'nullable',
                'dispatched' => 'nullable',
                'addres_name' => 'nullable',
                'addres_lat' => 'nullable',
                'addres_lng' => 'nullable',
                'address_description' => 'nullable',
                'zone' => 'nullable',
                'concept' => 'nullable',
                'rate' => 'nullable',
                'value' => 'nullable',
                'corp_value' => 'nullable',
                'document_type_customes' => 'nullable',
                'contact' => 'nullable',
                'phone_contact' => 'nullable',
                'email_contact' => 'nullable',
                'invoice_contact' => 'nullable',
                'same_day_delivery' => 'nullable',
                'sign' => 'nullable',
                'take_photo' => 'nullable',
                'packaging' => 'nullable',
                'state' => 'nullable'
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
                'branch_office' => $request->branch_office,
                'transport_type' => $request->transport_type,
                'dispatched' => $request->dispatched,
                'addres_name' => $request->addres_name,
                'addres_lat' => $request->addres_lat,
                'addres_lng' => $request->addres_lng,
                'address_description' => $request->address_description,
                'zone' => $request->zone,
                'concept' => $request->concept,
                'rate' => $request->rate,
                'value' => $request->value,
                'corp_value' => $request->corp_value,
                'document_type_customes' => $request->document_type_customes,
                'contact' => $request->contact,
                'phone_contact' => $request->phone_contact,
                'email_contact' => $request->email_contact,
                'invoice_contact' => $request->invoice_contact,
                'same_day_delivery' => $request->same_day_delivery,
                'sign' => $request->sign,
                'take_photo' => $request->take_photo,
                'packaging' => $request->packaging,
                'state' => $request->state
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
