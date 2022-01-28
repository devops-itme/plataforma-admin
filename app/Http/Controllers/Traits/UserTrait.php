<?php

use App\Http\Controllers\Traits\RestActions;
use App\User;

trait UserTrait
{
    use RestActions;

    public function saveUser($request)
    {
        try {
            $user = User::create([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'role' => $request->role,
                'state' => $request->state
            ]);

            $this->respond(200, $user, null, 'Usuario creado exitosamente');
        } catch (Exception $e) {
            $this->respond(500, [], $e->getMessage() . 'Error al crear usuario');
        }
    }
}
