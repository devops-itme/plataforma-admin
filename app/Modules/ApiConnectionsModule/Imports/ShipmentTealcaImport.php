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
            
            if ($requestResponse['state'] != 200) {
                return $requestResponse;
            }
            
            dd($row);
            return new Guide([
                // 'order_id' => $this->order_id,
                'address_name' => $row['paisdes'],
                'concept' => $row['concepto'],
                'contact' => $row['contacto'],
                'phone_contact' => $row['contactotelefono'],
                'email_contact' => $row['contactoemail']
            ]);
        }
    }
}
