<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Customer;

trait CustomerTrait
{
    use RestActions;

    public function customerValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'birthday' => 'nullable|date|before:today',
                'zone' => 'nullable',
                'contact' => 'nullable|string',
                'payment_period' => 'nullable',
                'credit' => 'nullable|integer',
                'taxes' => 'nullable',
                'receive_emails' => 'nullable',
                'fullfill' => 'nullable',
                'handling' => 'nullable',
                'COD_value' => 'nullable',
                'business_name' => 'nullable|string',
                'tradename' => 'nullable|string',
                'insured_value' => 'nullable',
                'money_to_collect' => 'nullable',
                'percentage_to_collect' => 'nullable'
            ]
        );
    }

    public function saveCustomer($request)
    {
        $validator = $this->customerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error, ', $validator->errors()->first());
        }
        try {
            $customer = Customer::create([
                'user_id' => $request->user_id,
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
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect,
                'state' => 1
            ]);
            return $this->respond(200, $customer, null, 'Cliente creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear cliente');
        }
    }

    public function updateCustomer($request, $id)
    {
        $validator = $this->customerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $customer = Customer::find($id);
            if (is_null($customer)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el usuario');
            }
            //Actualizar tabla usuario
            $updateUser = $this->updateUser($request->merge(['user_id' => $customer->user_id]));
            if ($updateUser['state'] != 200) {
                return $this->respond(500, [], $updateUser['error'], $updateUser['message']);
            }
            $customer->update([
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
                'insured_value' => $request->insured_value,
                'money_to_collect' => $request->money_to_collect,
                'percentage_to_collect' => $request->percentage_to_collect
            ]);

            return $this->respond(200, $customer, null, 'Usuario actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar usuario');
        }
    }

    public function deleteCustomer($id)
    {
        try {
            $customer = Customer::find($id);
            if (is_null($customer)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el usuario');
            }
            $deleteUser = $this->deleteUser($customer->user_id);
            if ($deleteUser['state'] == 500) {
                return $this->respond(500, [], $deleteUser['error'], $deleteUser['message']);
            }
            $customer->delete();
            return $this->respond(200, $customer, null, 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar usuario');
        }
    }
}
