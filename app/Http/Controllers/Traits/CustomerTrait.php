<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Customer;

trait CustomerTrait
{
    use RestActions;

    public function saveCustomer($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'birthday' => 'required|date|before:today',
                'zone_id' => 'required',
                'contact' => 'required|string',
                'payment_period' => 'required',
                'credit' => 'required|string',
                'taxes' => 'required',
                'receive_emails' => 'nullable',
                'fullfill' => 'required',
                'handling' => 'required',
                'COD_value' => 'required',
                'business_name' => 'required|string',
                'tradename' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }
        try {
            //Crear usuario en la tabla users
            $saveUserData = $this->saveUser($request);
            if($saveUserData['state'] == 200){
                $customer = Customer::create([
                    'user_id' => $saveUserData['data']->id,
                    'birthday' => $request->birthday,
                    'zone_id' => $request->zone,
                    'contact' => $request->contact,
                    'payment_period' => $request->payment_period,
                    'credit' => $request->credit,
                    'taxes' => $request->taxes,
                    'receive_emails' => $request->receive_emails,
                    'fullfill' => $request->fullfill,
                    'handling' => $request->handling,
                    'COD_value' => $request->COD_value,
                    'business_name' => $request->business_name,
                    'tradename' => $request->tradename,
                    'state' => 1
                ]);

                return $this->respond(200, $customer, null, 'Usuario creado exitosamente');
            } else {
                return $this->respond(500, [], 'Error al crear usuario');
            }

        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear usuario');
        }
    }
}
