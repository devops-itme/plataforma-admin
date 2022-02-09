<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Customer;
use App\User;

trait CustomerTrait
{
    use  UserTrait, BranchOfficeTrait;

    public function customerValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'birthday' => 'required|date|before:today',
                'zone' => 'required',
                'contact' => 'required|string',
                'payment_period' => 'required',
                'credit' => 'required|string',
                'taxes' => 'required',
                'receive_emails' => 'nullable',
                'fullfill' => 'required',
                'handling' => 'required',
                'COD_value' => 'required',
                'business_name' => 'nullable|string',
                'tradename' => 'nullable|string'
            ]
        );
    }

    public function saveCustomer($request)
    {
        $validator = $this->customerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
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
                'state' => 1
            ]);
            return $this->respond(200, $customer, null, 'Usuario creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear usuario');
        }
    }

    public function updateCustomer($request, $id)
    {
        $validator = $this->customerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }

        try {
            $customer = Customer::find($id);
            if (is_null($customer)) {
                return $this->respond(500, [], 'user not found', 'No se encontro el usuario');
            }
            //Actualizar tabla usuario
            $updateUser = $this->updateUser($request->merge(['user_id' => $customer->user_id]));
            if($updateUser['state'] != 200){
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
                'tradename' => $request->tradename
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
            if(is_null($customer)){
                return $this->respond(500, [], 'user not found', 'No se encontro el usuario');
            }
            $deleteUser = $this->deleteUser($customer->user_id);
            if($deleteUser['state'] == 500){
                return $this->respond(500, [], $deleteUser['error'], $deleteUser['message']);
            }
            $customer->delete();
            return $this->respond(200, $customer, null, 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar usuario');
        }
    }
}
