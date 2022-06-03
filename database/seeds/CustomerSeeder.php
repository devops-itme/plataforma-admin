<?php

use App\Modules\CustomerModule\Customer;
use App\Modules\UserModule\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name' => 'Cuss Tom',
                'last_name' => 'Er Clint',
                'document_type' => 2,
                'document_number' => '1478523691',
                'email' => 'customer@me.com',
                'phone' => '3123456789',
                'password' => 'secret',
                'role' => 4,
                'business_name' => 'Er Clint',
                'tradename' => 'Er Clint',
            ],
        ];
        foreach ($customers as $customer) {
            $user = User::create([
                'name' => $customer['name'],
                'last_name' => $customer['last_name'],
                'document_type' => $customer['document_type'],
                'document_number' => $customer['document_number'],
                'email' => $customer['email'],
                'phone' => $customer['phone'],
                'password' => Hash::make($customer['password']),
                'role' => $customer['role'],
            ]);
            $customer = Customer::create([
                'user_id' => $user->id,
                'business_name' => $customer['business_name'],
                'tradename' => $customer['tradename'],
            ]);
        }
    }
}
