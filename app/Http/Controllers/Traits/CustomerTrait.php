<?php

namespace App\Http\Controllers\Traits;
use App\Http\Controllers\Traits\RestActions;
use App\Customer;

trait CustomerTrait
{
    use RestActions;

    public function saveCustomer($request)
    {
        try {
            //Crear usuario en la tabla users
            $saveUserData = $this->saveUser($request);
            dd($saveUserData);

            // $this->respond(200, $user, null, 'Usuario creado exitosamente');
        } catch (Exception $e) {
            $this->respond(500, [], $e->getMessage() . 'Error al crear usuario');
        }
    }
}
