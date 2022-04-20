<?php

namespace App\Modules\ApiConnectionsModule\Imports;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use App\Modules\GuideModule\Guide;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShipmentTealcaImport implements ToModel, WithHeadingRow
{
    use RestActions;

    protected $Tealca;

    public function __construct()
    {
        $this->Tealca = new Tealca();
        $loginResponse = $this->Tealca->login();

        if ($loginResponse['state'] != 200) {
            return $loginResponse;
        };
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row) {
            $destination = $row['ciudes'];
            $requestResponse = $this->Tealca->requestDestination($destination);
            // dd($requestResponse);
            if ($requestResponse['state'] != 200) {
                return $requestResponse;
            }

            dd($row);
            return new Guide([
                'order_id',
                'branch_office',
                'transport_type',
                'dispatched',
                'address_name',//*
                'address_lat',
                'address_lng',
                'address_description',
                'description',//*
                'zone',
                'concept',
                'rate',
                'value',
                'corp_value',
                'customer_document_type',
                'contact',//*
                'phone_contact',//*
                'email_contact',//*
                'invoice_contact',
                'same_day_delivery',
                'sign',
                'take_photo',
                'packaging',
                'return_last_destination',
                'state',
                'app_status',
                'boxes',
                'status_matrix_id',
                'additional_address',
                'additional_email',
                'additional_phone',
            ]);
        }
    }
}
