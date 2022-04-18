<?php

namespace App\Imports;

use App\Modules\GuideModule\Guide;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuidesImport implements ToModel, WithHeadingRow
{

    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row){
            return new Guide([
                'order_id' => $this->order_id,
                'address_name' => $row['direccion'],
                'concept' => $row['concepto'],
                'contact' => $row['contacto'],
                'phone_contact' => $row['contactotelefono'],
                'email_contact' => $row['contactoemail']
            ]);
        }
    }
}
