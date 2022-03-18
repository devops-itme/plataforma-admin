<?php

namespace App\Http\Controllers\Traits;

use App\Box;
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
                'address_name' => 'nullable',
                'address_lat' => 'nullable',
                'address_lng' => 'nullable',
                'address_description' => 'nullable',
                'zone' => 'nullable',
                'concept' => 'nullable',
                'rate' => 'nullable',
                'value' => 'nullable',
                'corp_value' => 'nullable',
                'customer_document_type' => 'nullable',
                'contact' => 'nullable',
                'phone_contact' => 'nullable',
                'email_contact' => 'nullable',
                'invoice_contact' => 'nullable',
                'same_day_delivery' => 'nullable',
                'sign' => 'nullable',
                'take_photo' => 'nullable',
                'packaging' => 'nullable',
                'return_last_destination' => 'nullable',
            ]
        );
    }

    public function storeGuide($request)
    {
        $validator = $this->GuideValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $order = Guide::create([
                'order_id' => $request->order_id ?? null,
                'description' => $request->guide_description,
                'branch_office' => $request->branch_office,
                'transport_type' => $request->transport_type,
                'dispatched' => $request->dispatched,
                'address_name' => $request->address_name,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
                'address_description' => $request->address_description,
                'zone' => $request->zone,
                'concept' => $request->concept,
                'rate' => $request->rate,
                'value' => $request->value,
                'corp_value' => $request->corp_value,
                'customer_document_type' => $request->customer_document_type,
                'contact' => $request->contact,
                'phone_contact' => $request->phone_contact,
                'email_contact' => $request->email_contact,
                'invoice_contact' => $request->invoice_contact,
                'same_day_delivery' => $request->same_day_delivery,
                'sign' => $request->sign,
                'take_photo' => $request->take_photo,
                'packaging' => $request->packaging,
                'return_last_destination' => $request->return_last_destination,
                'boxes' => $request->boxes
            ]);
            return $this->respond(200, $order, null, 'Guiá creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear guiá');
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
                return $this->respond(500, [], 'user not found', 'No se encontró la guía');
            }
            $guide->update([
                // 'dispatched' => $request->dispatched,
                'branch_office' => $request->branch_office,
                'address_name' => $request->address_name,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
                'address_description' => $request->address_description,
                'zone' => $request->zone,
                'concept' => $request->concept,
                'rate' => $request->rate,
                'value' => $request->value,
                'corp_value' => $request->corp_value,
                'customer_document_type' => $request->customer_document_type,
                'contact' => $request->contact,
                'phone_contact' => $request->phone_contact,
                'email_contact' => $request->email_contact,
                'invoice_contact' => $request->invoice_contact,
                'same_day_delivery' => $request->same_day_delivery,
                'sign' => $request->sign,
                'take_photo' => $request->take_photo,
                'packaging' => $request->packaging,
                'return_last_destination' => $request->return_last_destination,
                'boxes' => $request->boxes
            ]);
            return $this->respond(200, $guide, null, 'Guía actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar guía');
        }
    }

    public function setAdditionalInformation($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'guide_id' => 'required|exists:guides,id',
                'additional_address' => 'nullable|string',
                'additional_email' => 'nullable|email',
                'additional_phone' => 'nullable|numeric',
            ]
        );

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $guide = Guide::find($request->guide_id);
            if (is_null($guide)) {
                return $this->respond(500, [], 'guide not found', 'No se encontró la orden');
            }

            $guide->update([
                'additional_address' => $request->additional_address,
                'additional_email' => $request->additional_email,
                'additional_phone' => $request->additional_phone,
            ]);

            return $this->respond(200, $guide, null, 'Orden actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar orden');
        }
    }

    public function deleteGuide($id)
    {
        try {
            $guide = Guide::find($id);
            if (is_null($guide)) {
                return $this->respond(500, [], 'user not found', 'No se encontró la guiá');
            }
            $guide->delete();
            return $this->respond(200, $guide, null, 'Guia eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar guiá');
        }
    }
}
