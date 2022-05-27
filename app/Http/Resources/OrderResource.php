<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "order_number" => $this->order_number,
            "order_value" => $this->order_value,
            "zone_id" => $this->zone_id,
            "receive_by_COD" => $this->receive_by_COD,
            "internal_product" => $this->internal_product,
            "expenses" => $this->expenses,
            "diligence_expenses" => $this->diligence_expenses,
            "tax_total" => $this->tax_total,
            "rate_value" => $this->rate_value,
            "tax_percentage" => $this->tax_percentage,
            "urgent_dispatch" => $this->urgent_dispatch,
            "schedule_date" => Carbon::parse($this->schedule_date)->format('d/m/Y'),
            'paid' => $this->paid,
            "schedule_time" => [
                'id' => $this->getScheduleTime->id ?? '',
                'day_id' => $this->getScheduleTime->day_id ?? '',
                'day' => $this->getScheduleTime->getDay->name ?? '',
                'init_time' => $this->getScheduleTime->init_time ?? '',
                'end_time' => $this->getScheduleTime->end_time ?? '',
                'range' => ($this->getScheduleTime->init_time ?? '') . ' - ' . ($this->getScheduleTime->end_time ?? ''),
            ],
            "diffForHumans" => Carbon::parse($this->schedule_date)->diffForHumans(),
            "insured_value" => $this->insured_value,
            "money_to_collect" => $this->money_to_collect,
            "percentage_to_collect" => $this->percentage_to_collect,
            "app_status" => $this->app_status,
            "address" => [
                "id" => $this->getAddress->id ?? '',
                "name" => $this->getAddress->name ?? ($this->address_name ?? ''),
                "lat" => $this->getAddress->lat ?? ($this->address_lat ?? ''),
                "lng" => $this->getAddress->lng ?? ($this->address_lng ?? ''),
                "description" => $this->getAddress->description ?? ($this->address_description ?? ''),
            ],
            "description" => $this->description,
            "user" => [
                "id" => $this->getUser->id ?? '',
                "name" => $this->getUser->name,
                "last_name" => $this->getUser->last_name ?? '',
                "document_type" => [
                    "id" => $this->getUser->getDocumentType->id ?? '',
                    "name" => $this->getUser->getDocumentType->name ?? '',
                ],
                "document_number" => $this->getUser->document_number ?? '',
                "email" => $this->getUser->email ?? '',
                "phone" => $this->getUser->phone ?? '',
            ],
            "order_type" => [
                "id" => $this->getOrderType->id ?? '',
                "name" => $this->getOrderType->name ?? '',
            ],
            "payment_method" => [
                "id" => $this->getPaymentMethod->id ?? '',
                "name" => $this->getPaymentMethod->name ?? '',
            ],
            // "state" => [
            //     "id" => $this->getState->id ?? '',
            //     "name" => $this->getState->name ?? '',
            // ],
            "status_matrix" => [
                "id" => $this->getStatusMatrix->id ?? '',
                "name" => $this->getStatusMatrix->name ?? '',
                "scope_id" => $this->getStatusMatrix->scope_id ?? '',
            ],
            "department" => [
                "id" => $this->getDepartment->id ?? '',
                "name" => $this->getDepartment->name ?? '',
                "description" => $this->getDepartment->description ?? '',
            ],
            "branch_office" => [
                "id" => $this->getBranchOffice->id ?? '',
                "name" => $this->getBranchOffice->name ?? '',
                'description' => $this->getBranchOffice->description ?? '',
                // 'type' => $this->getBranchOffice->name ?? '',
                // 'zone_id' => $this->getBranchOffice->name ?? '',
                'address' => $this->getBranchOffice->address ?? '',
                'email' => $this->getBranchOffice->email ?? '',
                'contact' => $this->getBranchOffice->contact ?? '',
                // 'document_type' => $this->getBranchOffice->name ?? '',
                'document_number' => $this->getBranchOffice->document_number ?? '',
                'lat' => $this->getBranchOffice->lat ?? '',
                'lng' => $this->getBranchOffice->lng ?? '',
                'default' => $this->getBranchOffice->default ?? '',
                // 'payment_method' => $this->getBranchOffice->name ?? '',
                'phone' => $this->getBranchOffice->phone ?? '',
                'usage_mode' => $this->getBranchOffice->usage_mode ?? '',
            ],
        ];
    }
}
