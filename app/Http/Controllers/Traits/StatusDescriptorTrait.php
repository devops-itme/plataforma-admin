<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\StatusDescriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait StatusDescriptorTrait
{
    use TraitsRestActions;


    public function validateStatusDescriptor($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'role_id' => 'required',
                'description' => 'required'
            ]
        );


    }

    public function storeDescriptor($request , $id)
    {
        $validator = $this->validateStatusDescriptor($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' , $validator->errors()->first());
        }
        try {
            $statusDescriptor = StatusDescriptor::updateOrCreate([
                'role_id' =>  $request->role_id, 'status_matrix_id' => $id,
            ], [
                'role_id' =>  $request->role_id,
                'description' => $request->description,
                'status_matrix_id' => $id,
            ]);
            return $this->respond(200, $statusDescriptor, null, 'Descriptor creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear el descriptor');
        }
    }


}
