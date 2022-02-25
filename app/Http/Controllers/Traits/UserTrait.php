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
                'name' => 'nullable|string',
                'last_name' => 'nullable|string',
                'document_type' => 'nullable|exists:parameter_values,id',
                'document_number' => [
                    'nullable', 'string',
                    Rule::unique('users', 'document_number')->ignore($id)->whereNull('deleted_at')
                ],
                'email' => [
                    'required', 'email',
                    Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at')
                ],
                'phone' => [
                    'nullable', 'string',
                    Rule::unique('users', 'phone')->ignore($id)->whereNull('deleted_at')
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

    public function getUser()
    {
        try {
            $users = User::name(request()->name)
            ->document(request()->document)
            ->email(request()->email)
            ->phone(request()->phone)
            ->state(request()->state)
            ->paginate(10);
            return $this->respond(200, $users);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showUser($id)
    {
        try {
            $users = User::where('id', $id)->first();
            return $this->respond(200, $users);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
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
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $user, null, 'Usuario creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear usuario');
        }
    }

    public function updateUser($request)
    {
        $validator = $this->valide($request,null,$request->user_id);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $user = User::find($request->user_id);
            if (is_null($user)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el usuario');
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
                return $this->respond(500, [], 'user not found', 'No se encontró el usuario');
            }
            $user->delete();
            return $this->respond(200, $user, null, 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar usuario');
        }
    }
}
