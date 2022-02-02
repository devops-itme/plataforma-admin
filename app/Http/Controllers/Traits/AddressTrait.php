<?php

namespace App\Http\Controllers\Traits;

use App\Address;
use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\ParameterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait AddressTrait
{
    use TraitsRestActions;

    public function addressesValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'lat' => 'required',
                'lng' => 'required',
                'state' => 'required',

            ]
        );
    }
    public function getAddresses()
    {
        try {
            $addresses = Address::get();
            return $this->respond(200, $addresses);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showAddress($id)
    {
        try {
            $address = Address::where('id', $id)->first();
            return $this->respond(200, $address);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function saveAddress($request)
    {
        $validator = $this->AddressesValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {
            $address = Address::create([
                $request->all()
            ]);
            return $this->respond(200, $address, null, 'Dirección creado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear dirección');
        }
    }
    public function updateAddress($request, $id)
    {
        try {
            $validator = $this->addressesValidate($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
            }
            $address = Address::find($id);
            $address->update($request->all());

            return $this->respond(200, $address, null, 'Dirección actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar dirección');
        }
    }
    public function deleteAddress($id)
    {
        try {
            $address = Address::find($id);
            $address->delete();
            return $this->respond(200, $address, null, 'Dirección eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar dirección');
        }
    }
}
