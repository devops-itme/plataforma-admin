<?php

namespace App\Imports;

use App\Modules\MessengerModule\Messenger;
use App\Modules\UserModule\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MessengersImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row){
            $user = User::create([
                'name' => $row['nombre'],
                // 'last_name' => $row['last_name'],
                // 'document_type' => $row['document_type'],
                'document_number' => $row['id'],
                // 'email' => $row['email'],
                // 'phone' => $row['phone'],
                'password' => Hash::make('123456'),
                'role' => 3,
            ]);
            $messenger = Messenger::create([
                'user_id' => $user->id,
                'number' => $row['numero'],
                'vehicle_plate' => $row['placa'] ?? 'NO REGISTRA',
                'admission_date' => (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fechaingreso'])),
                'production_percentage' => $row['comision'],
                'exclusive' => $row['snexclusivo'],
                // 'birth_date' => $row['birth_date'],
                // 'contract_type_id' => 0
            ]);
            return;
        }
    }
}
