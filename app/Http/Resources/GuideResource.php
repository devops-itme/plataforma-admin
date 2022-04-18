<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "branch_office" => $this->branch_office,
            "transport_type" => $this->transport_type,
            "dispatched" => $this->dispatched,
            "address_name" => $this->address_name,
            "address_lat" => $this->address_lat,
            "address_lng" => $this->address_lng,
            "address_description" => $this->address_description,
            "description" =>  $this->description,
            "zone" =>  $this->zone,
            "concept" =>  $this->concept,
            "rate" =>  $this->rate,
            "value" =>  $this->value,
            "corp_value" => $this->corp_value,
            "customer_document_type" => $this->customer_document_type,
            "contact" => $this->contact,
            "phone_contact" => $this->phone_contact,
            "email_contact" => $this->email_contact,
            "invoice_contact" => $this->invoice_contact,
            "same_day_delivery" => $this->same_day_delivery,
            "sign" => $this->sign,
            "take_photo" => $this->take_photo,
            "packaging" => $this->packaging,
            "return_last_destination" => $this->return_last_destination,
            "state" => $this->state,
            "app_status" => $this->app_status,
            "boxes" => $this->boxes,
            "status_matrix_id" => $this->status_matrix_id,
            "status_matrix" => [
                'id' => $this->getStatusMatrix->id,
                'name' => $this->getStatusMatrix->name,
                'scope_id' => $this->getStatusMatrix->scope_id,
                'updated_at' => $this->getStatusMatrix->updated_at,
            ],
            'created_at' => $this->created_at,
            "transport" => [
                "id" => $this->getTransportType->id ?? '',
                "name" => $this->getTransportType->name ?? '',
            ],
            "messenger" => [
                "user_id" => $this->getRoute->getMessenger->id ?? '',
                "name" => $this->getRoute->getMessenger->name ?? '',
                "last_name" => $this->getRoute->getMessenger->last_name ?? '',
                "document_type" => $this->getRoute->getMessenger->document_type ?? '',
                "document_number" => $this->getRoute->getMessenger->document_number ?? '',
                "email" => $this->getRoute->getMessenger->email ?? '',
                "phone" => $this->getRoute->getMessenger->phone ?? '',
                "role" => $this->getRoute->getMessenger->role ?? '',
                "state" => $this->getRoute->getMessenger->state ?? '',
                "messenger_id" => $this->getRoute->getMessenger->getMessenger->id ?? '',
                "vehicle_plate" => $this->getRoute->getMessenger->getMessenger->vehicle_plate ?? '',
                "admission_date" => $this->getRoute->getMessenger->getMessenger->admission_date ?? '',
                "birth_date" => $this->getRoute->getMessenger->getMessenger->birth_date ?? '',
                "production_percentage" => $this->getRoute->getMessenger->getMessenger->production_percentage ?? '',
                "contract" => $this->getRoute->getMessenger->getMessenger->contract ?? '',
                "exclusive" => $this->getRoute->getMessenger->getMessenger->exclusive ?? '',
                "contract_type_id" => $this->getRoute->getMessenger->getMessenger->contract_type_id ?? '',
            ],
        ];
    }
}
