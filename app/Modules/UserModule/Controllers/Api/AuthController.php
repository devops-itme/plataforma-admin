<?php

namespace App\Modules\UserModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\AddressModule\Controllers\AddressTrait;
use App\Modules\CustomerModule\Controllers\CustomerTrait;
use App\Mail\CodeMail;
use App\Modules\RoleModule\Role;
use App\Modules\UserModule\User;
use App\Modules\UserModule\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use CustomerTrait, AddressTrait;

    public function respond($state, $data = [], $error = null, $message = '')
    {
        return [
            'state' => $state, //response status
            'data' => $data, //response data
            'error' => $error, //bug for developer
            'message' => $message //user message
        ];
    }

    public function Login(Request $request)
    {
        $is_numeric = is_numeric($request->user);

        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits_between:8,10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
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

            $user_role = Role::where('name', $request->user_type)->first();
            $user_role_id = $user_role->id;

            if ($user->role != $user_role_id) {
                return $this->respond(401,  null, 'Unauthorized', 'El usuario no es un ' . $request->user_type);
            }

            if ($user->state != 1) {
                return $this->respond(401,  null, 'Unauthorized', 'Usuario inactivo');
            }
            $user->fcm_token = $request->fcm_token ?? NULL;
            $user->save();

            $token = $user->createToken('authToken')->plainTextToken;
            return $this->respond(200, $token, null, 'Acceso permitido');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . ' Line:' . $e->getLine(), 'Ha ocurrido un error de servidor');
        }
    }

    public function signOut(Request $request)
    {
        // $user = Auth::user();
        // $user->tokens()->delete();
        return $this->respond(200, null, null, 'Session cerrada con éxito');
    }

    public function recovery(Request $request)
    {
        $is_numeric = is_numeric($request->user);
        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits_between:8,10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
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

            $sms_response = send_sms($user->phone, 'Su código de verificación es:' . $randomCode);
            Mail::to($user->email)
                ->send(new CodeMail($randomCode));
            return $this->respond(200, $randomCode, $sms_response, 'Código de verificación generado con éxito');
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
                ($is_numeric ? 'digits_between:8,10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
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

            return $this->respond(200, null, null, 'Código verificado con éxito');
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
                    ($is_numeric ? 'digits_between:8,10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
                ],
                'password' => 'required|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }

            $user = User::where($is_numeric ? 'phone' : 'email', $request->user)->first();
            send_sms($user->phone, 'Su nueva contraseña es:' . $request->password);
            $user->password = Hash::make($request->password);
            $user->update();

            return $this->respond(200, null, null, 'Contraseña restaurada con éxito');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function forward(Request $request)
    {
        $is_numeric = is_numeric($request->user);
        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits_between:8,10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
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

            send_sms($user->phone, 'Su código de verificación es:' . $randomCode);
            Mail::to($user->email)
                ->send(new CodeMail($randomCode));
            return $this->respond(200, $randomCode, null, 'Código de verificación generado con éxito');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function registerCustomer(Request $request)
    {
        $request->taxes = $request->taxes == 'on' ? 1 : 0;
        $request->merge(['role' => 4]);

        $validator = $this->validateUser($request, 'create');

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        $validator = $this->customerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        if (!is_null($request->address)) {
            $validator = $this->AddressesValidate($request, 'create');

            if ($validator->fails()) {
                return $this->respond(500, [],  $validator->errors(),  $validator->errors()->first());
            }
        }

        try {
            $saveUserResponse = $this->saveUser($request);
            $user_id = $saveUserResponse['data']->id;

            if (!is_null($request->address)) {
                $saveAddressResponse = $this->saveAddress($request->merge(['user_id' => $user_id]));
                if ($saveAddressResponse['state'] != 200) {
                    return $saveAddressResponse;
                }
            };
            $saveCustomerResponse = $this->saveCustomer($request->merge(['user_id' => $user_id]));
            if ($saveCustomerResponse['state'] == 200) {
                $randomCode = rand(100000, 999999);
                $user = User::where('id', $user_id)->first();
                $user->code = $randomCode;
                $user->code_confirmed = 0;
                $user->update();
                send_sms($user->phone, 'Su código de verificación es:' . $randomCode);
                Mail::to($user->email)
                    ->send(new CodeMail($randomCode));
            }
            return $saveCustomerResponse;
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function deleteAccount()
    {
        $UserModel = new UserModel();
        return $UserModel->deleteAccount();
    }


    //LOGIN FOR INTERNATIONAL ORDERS WITHOUT ROLE TYPE(REQUEST)

    public function LoginClient(Request $request)
    {
        $is_numeric = is_numeric($request->user);

        $validator = Validator::make($request->all(), [
            'user' => [
                'required',
                ($is_numeric ? 'exists:users,phone' : 'exists:users,email'),
                ($is_numeric ? 'digits_between:8,10' : 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,4}/'),
            ],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->respond(400, $validator->errors(), 'Bad Request', 'Error de validacion');
        }

        $access_type = $is_numeric ? 'phone' : 'email';
        $request->merge([$access_type => $request->user]);
        $credentials = request([$access_type, 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->respond(401,  $credentials, 'Unauthorized', 'Credenciales invalidas');
        }

        try {
            $user = User::where(($is_numeric ? 'phone' : 'email'), $request->user)->first();

            $user_role_c = Role::where('name', 'Cliente')
                ->first();

            $user_role_a = Role::where('name', 'Admin')
                ->first();

            $user_role_id_c = $user_role_c->id;
            $user_role_id_a = $user_role_a->id;

            if ($user_role_id_c == null) {
                if ($user->role != $user_role_id_a) {
                    return $this->respond(401,  null, 'Unauthorized', 'Acceso denegado');
                }
            }

            if ($user_role_id_a == null) {
                if ($user->role != $user_role_id_c) {
                    return $this->respond(401,  null, 'Unauthorized', 'Acceso denegado');
                }
            }

            if ($user->state != 1) {
                return $this->respond(401,  null, 'Unauthorized', 'Usuario inactivo');
            }
            $user->fcm_token = $request->fcm_token ?? NULL;
            $user->save();

            $token = $user->createToken('authToken')->plainTextToken;
            return $this->respond(200, $token, null, 'OK');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . ' Line:' . $e->getLine(), 'Ha ocurrido un error de servidor');
        }
    }
}
