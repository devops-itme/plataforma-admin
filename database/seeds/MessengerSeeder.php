<?php

use App\Modules\MessengerModule\Messenger;
use App\Modules\UserModule\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MessengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messengers = [
            [
                'name' => 'MENSAJERO',
                'last_name' => 'PRUEBA',
                'document_type' => 2,
                'document_number' => '1193685265',
                'email' => 'pmanager2@developapp.co',
                'phone' => '3027140176',
                'password' => '123456',
                'role' => 3,
                'vehicle_plate' => 'M3N54J3R0',
                'admission_date' =>null,
                'birth_date' => null,
                'production_percentage' => 10.5,
                'exclusive' => 15,
                'contract_type_id' => 0,
            ],
            [
                'name' => 'Jaimito',
                'last_name' => 'Cartero',
                'document_type' => 2,
                'document_number' => '1198635265',
                'email' => 'jcarter@email.com',
                'phone' => '3222222222',
                'password' => 'secret',
                'role' => 3,
                'vehicle_plate' => 'C4RT3R0',
                'admission_date' =>null,
                'birth_date' => null,
                'production_percentage' => 12.5,
                'exclusive' => 20,
                'contract_type_id' => 0,
            ],
        ];
        foreach ($messengers as $messenger) {
            $user = User::create([
                'name' => $messenger['name'],
                'last_name' => $messenger['last_name'],
                'document_type' => $messenger['document_type'],
                'document_number' => $messenger['document_number'],
                'email' => $messenger['email'],
                'phone' => $messenger['phone'],
                'password' => Hash::make($messenger['password']),
                'role' => $messenger['role'],
            ]);
            $messenger = Messenger::create([
                'user_id' => $user->id,
                'vehicle_plate' => $messenger['vehicle_plate'],
                'admission_date' => $messenger['admission_date'],
                'production_percentage' => $messenger['production_percentage'],
                'exclusive' => $messenger['exclusive'],
                'birth_date' => $messenger['birth_date'],
                'contract_type_id' => $messenger['contract_type_id']
            ]);
        }
    }
}
