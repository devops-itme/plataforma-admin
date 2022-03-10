<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CustomerTrait;
use App\Customer;
use App\Http\Controllers\Traits\UserTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    use UserTrait, CustomerTrait;

    public function store(Request $request)
    {
        $validator = $this->validateUser($request, 'create');

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        $validator = $this->customerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }

        try {
            $saveUserResponse = $this->saveUser($request->merge(['state' => 1, 'role' => 4]));
            $user_id = $saveUserResponse['data']->id;
            $saveUserResponse = $this->saveCustomer($request->merge(['user_id' => $user_id]));
            return $saveUserResponse;
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function show()
    {
        $user_id = Auth::user()->id;
        if (is_null($user_id)) {
            return $this->respond(401,  null, 'Unauthorized', 'Acceso denegado');
        }
        try {
            $user = User::where('id', $user_id)->with('getCustomer')->first();
            return $this->respond(200, $user, null, 'Datos del cliente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        if (is_null($user_id)) {
            return $this->respond(401,  null, 'Unauthorized', 'Acceso denegado');
        }
        try {
            $customer = Customer::where('user_id', $user_id)->first();
            $customer_id = $customer->id;
            $response = $this->updateCustomer($request, $customer_id);
            return $response;
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
