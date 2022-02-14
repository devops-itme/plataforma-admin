<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use RestActions;

    public function SignIn(Request $request)
    {
        $is_numeric = is_numeric($request->user);

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

    public function signOut(Request $request)
    {
        // $user = Auth::user();
        // $user->tokens()->delete();
        return $this->respond(200, null, null, 'Session cerrada con exito');
    }

    public function recovery(Request $request)
    {
        $is_numeric = is_numeric($request->user);
        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits:10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
            ],
        ]);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $randomCode = rand(100000, 999999);
            $user = User::where($is_numeric ? 'phone' : 'email', $request->user)->first();
            $user->code = $randomCode;
            $user->code_confirmed = 0;
            $user->update();

            // send_sms($user->phone, 'Su código de verificación es:' . $randomCode );
            // Mail::to($user->email)
            //     ->send(new CodeMail($randomCode));
            return $this->respond(200, $randomCode, null, 'Codigo de verificación generado con exito');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function verifyCode(Request $request)
    {
        $is_numeric = is_numeric($request->user);
        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits:10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
            ],
            'code' => 'required|exists:users,code'
        ]);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {

            $user = User::where($is_numeric ? 'phone' : 'email', $request->user)->first();
            $user->code = '';
            $user->code_confirmed = 1;
            $user->update();

            return $this->respond(200, null, null, 'Codigo verificado con exito');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function restore(Request $request)
    {
        try {
            $is_numeric = is_numeric($request->user);
            $validator = Validator::make($request->all(), [
                'user' => [
                    'required',
                    ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                    ($is_numeric ? 'digits:10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
                ],
                'password' => 'required|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }

            $user = User::where($is_numeric ? 'phone' : 'email', $request->user)->first();
            $user->password = Hash::make($request->password);
            $user->update();

            return $this->respond(200, null, null, 'Contraseña restaurada con exito');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function forward(Request $request)
    {
        $is_numeric = is_numeric($request->user);
        try {
            $validator = Validator::make($request->all(), [
                'user' => [
                    'required',
                    ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                    ($is_numeric ? 'digits:10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
                ],
            ]);

            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }

            $randomCode = rand(100000, 999999);
            $user = User::where($is_numeric ? 'phone' : 'email', $request->user)->first();
            $user->code = $randomCode;
            $user->code_confirmed = 0;
            $user->update();

            // send_sms($user->phone, 'Su código de verificación es:' . $randomCode );
            // Mail::to($user->email)
            //     ->send(new CodeMail($randomCode));
            return $this->respond(200, $randomCode, null, 'Codigo de verificación generado con exito');

        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
