<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use RestActions;
    public function SignIn(Request $request)
    {
        $is_numeric = is_numeric($request->phone);

        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits:10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
            ],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        $access_type = $is_numeric ? 'phone' : 'email';
        $request->merge([$access_type => $request->user]);
        $credentials = request([$access_type, 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->respond(401,  $credentials, 'Unauthorized', 'Credenciales invalidas');
        }

        try {
            $user = User::where(($is_numeric ? 'phone' : 'email'), $request->user)->first();

            $messenger_role = Role::where('name', 'Mensajero')->first();
            $messenger_role_id = $messenger_role->id;
            dd($user->role , $messenger_role_id);
            if ($user->role != $messenger_role_id) {
                return $this->respond(401,  null, 'Unauthorized', 'El usuario no es un mensajero');
            }

            if ($user->state != 1) {
                return $this->respond(401,  null, 'Unauthorized', 'Usuario inactivo');
            }

            $token = $user->createToken('authToken')->plainTextToken;
            return $this->respond(200, $token, null, 'Acceso permitido');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
