<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ProfileTrait
{
    use RestActions;

    public function validateProfile($request, $action = null, $type = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => [Rule::requiredIf($type == 1), 'string'],
                'last_name' => [Rule::requiredIf($type == 1), 'string'],
                'document_type' => 'nullable|numeric',
                'document_number' => ['nullable', 'numeric', Rule::unique('users', 'document_number')->where($action == 'create')],
                'email' => ['email', Rule::unique('users', 'email')->where($action == 'create')->where($type == 1), Rule::requiredIf($type == 1)],
                'phone' => ['nullable', 'string', Rule::unique('users', 'phone')->where($action == 'create')->where($type == 1)],
            ]
        );
    }

    public function updateGeneralData($request)
    {
        $validator = $this->validateProfile($request, 'create', 1);
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $user = User::find(Auth::user()->id);
            if(is_null($user)){
                return $this->respond(500, [], 'User not found', 'No se encontró el usuario');
            }
            $user->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'email' =>$request->email,
                'phone' => $request->phone
            ]);

            return $this->respond(200, $user, null, 'Usuario actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar usuario');
        }
    }
}
