<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait UserTrait
{
    use RestActions;

    public function valide($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'parent_id' => 'nullable|exists:users,id',
                'name' => 'required|string',
                'last_name' => 'nullable|string',
                'document_type' => 'nullable|exists:parameter_values,id',
                'document_number' => [
                    'nullable', 'string',
                    Rule::unique('users', 'document_number')->whereNull('deleted_at')->where('id', '<>', $id)
                ],
                'email' => [
                    'required', 'email',
                    Rule::unique('users', 'email')->whereNull('deleted_at')->where('id', '<>', $id)
                ],
                'phone' => [
                    'nullable', 'string',
                    Rule::unique('users', 'phone')->whereNull('deleted_at')->where('id', '<>', $id)
                ],
                'password' => [
                    'string',
                    $action == 'create' ? 'confirmed' : 'nullable',
                    Rule::requiredIf($action == 'create')
                ],
                'role' => 'nullable|numeric|exists:roles,id',
                'state' => 'nullable|numeric',
            ]
        );
    }

    public function saveUser($request)
    {
        $validator = $this->valide($request, 'create');

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $user = User::create([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'state' => $request->state
            ]);

            return $this->respond(200, $user, null, 'Usuario creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear usuario');
        }
    }

    public function updateUser($request)
    {
        $validator = $this->valide($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $user = User::find($request->user_id);
            if (is_null($user)) {
                return $this->respond(500, [], 'user not found', 'No se encontro el usuario');
            }
            $user->update([
                'parent_id' => $request->parent_id ?? $user->parent_id,
                'name' => $request->name ?? $user->name,
                'last_name' => $request->last_name ?? $user->last_name,
                'document_type' => $request->document_type ?? $user->document_type,
                'document_number' => $request->document_number ?? $user->document_number,
                'email' => $request->email ?? $user->email,
                'phone' => $request->phone ?? $user->phone,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                // 'role' => $request->role ?? $user->role,
                'state' => $request->state ?? $user->state
            ]);

            return $this->respond(200, $user, null, 'Usuario actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar usuario');
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::find($id);
            if (is_null($user)) {
                return $this->respond(500, [], 'user not found', 'No se encontro el usuario');
            }
            $user->delete();
            return $this->respond(200, $user, null, 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar usuario');
        }
    }
}
