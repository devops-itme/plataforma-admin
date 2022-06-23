<?php

namespace App\Modules\GuideModule\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuideModule\Guide;
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
                'address_id' => 'nullable',
                'address_name' => 'required|string|max:200',
                'address_lat' => 'nullable',
                'address_lng' => 'nullable',
                'address_description' => 'nullable',
                'zone' => 'nullable',
                'country' => 'required|string|size:3',
                'city' => 'required|string|size:3',
                'recipient_name' => 'required|string',
                'document_type' => 'required|string',
                'document' => 'required|numeric',
                'delivery_office' => 'required|string',
                'pre_guide' => 'required|numeric',
                'invoice_number' => 'required|alpha_num',
                'declared' => 'required|numeric',
                'pieces' => 'required|numeric',
                'kg' => 'required|numeric',
                'concept' => 'nullable',
                'rate' => 'nullable',
                'value' => 'nullable',
                'corp_value' => 'nullable',
                'customer_document_type' => 'nullable',
                'contact' => 'required|string',
                'phone_contact' => 'required|numeric',
                'email_contact' => 'required|email',
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
                'description' => $request->description,
                'branch_office' => $request->branch_office,
                'transport_type' => $request->transport_type,
                'dispatched' => $request->dispatched,
                "address_id" => $request->address_id,
                'address_name' => $request->address_name,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
                'address_description' => $request->address_description,
                'detail_package' => $request->detail_package,
                'zone' => $request->zone,
                'country' => $request->country,
                'city' => $request->city,
                'recipient_name' => $request->recipient_name,
                'document_type' => $request->document_type,
                'document' => $request->document,
                'delivery_office' => $request->delivery_office,
                'pre_guide' => $request->pre_guide,
                'invoice_number' => $request->invoice_number,
                'declared' => $request->declared,
                'pieces' => $request->pieces,
                'kg' => $request->kg,
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
        $validator = $this->GuideValidate($request, null);
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
                'branch_office' => $request->branch_office ?? $guide->branch_office,
                'address_id' => $request->address_id ?? $guide->address_id,
                'address_name' => $request->address_name ?? $guide->address_name,
                'address_lat' => $request->address_lat ?? $guide->address_lat,
                'address_lng' => $request->address_lng ?? $guide->address_lng,
                'address_description' => $request->address_description ?? $guide->address_description,
                'detail_package' => $request->detail_package ?? $guide->detail_package,
                'description' => $request->description ?? $guide->description,
                'zone' => $request->zone ?? $guide->zone,
                'country' => $request->country ?? $guide->country,
                'city' => $request->city ?? $guide->city,
                'recipient_name' => $request->recipient_name ?? $guide->recipient_name,
                'document_type' => $request->document_type ?? $guide->document_type,
                'document' => $request->document ?? $guide->document,
                'delivery_office' => $request->delivery_office ?? $guide->delivery_office,
                'pre_guide' => $request->pre_guide ?? $guide->pre_guide,
                'invoice_number' => $request->invoice_number ?? $guide->invoice_number,
                'declared' => $request->declared ?? $guide->declared,
                'pieces' => $request->pieces ?? $guide->pieces,
                'kg' => $request->kg ?? $guide->kg,
                'concept' => $request->concept ?? $guide->concept,
                'rate' => $request->rate ?? $guide->rate,
                'value' => $request->value ?? $guide->value,
                'corp_value' => $request->corp_value ?? $guide->corp_value,
                'customer_document_type' => $request->customer_document_type ?? $guide->customer_document_type,
                'contact' => $request->contact ?? $guide->contact,
                'phone_contact' => $request->phone_contact ?? $guide->phone_contact,
                'email_contact' => $request->email_contact ?? $guide->email_contact,
                'invoice_contact' => $request->invoice_contact ?? $guide->invoice_contact,
                'same_day_delivery' => $request->same_day_delivery ?? $guide->same_day_delivery,
                'sign' => $request->sign ?? $guide->sign,
                'take_photo' => $request->take_photo ?? $guide->take_photo,
                'packaging' => $request->packaging ?? $guide->packaging,
                'return_last_destination' => $request->return_last_destination ?? $guide->return_last_destination,
                'boxes' => $request->boxes ?? $guide->boxes,
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
                'novelty' => 'nullable|string',
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
            $guide->update($request->all());
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
