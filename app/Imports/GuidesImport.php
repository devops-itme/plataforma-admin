<?php

namespace App\Imports;

use App\Guide;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuidesImport implements ToModel, WithHeadingRow,
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row){
            return new Guide([
                'document_type_customes' => $row['TipoDocumento'],
                'order_id' => $row['OrdenID'],
                'address_name' => $row['Direccion'],
                'concept' => $row['Concepto'],
                'contact' => $row['Contacto'],
                'phone_contact' => $row['ContactoTelefono'],
                'email_contact' => $row['ContactoEmail']
            ]);
        }
    }
}
