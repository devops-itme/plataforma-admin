<?php

namespace App\Modules\StatusDescriptorModule\Controllers;

use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Modules\StatusDescriptorModule\StatusDescriptor;
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
            return $this->respond(200, $statusDescriptor, null, 'Descriptor creado o actualizado  exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear o actualizar el descriptor');
        }
    }

    public function deleteDescriptor($id)
    {
        try {
            $descriptor = StatusDescriptor::find($id);
            $descriptor->delete();
            return $this->respond(200, $descriptor, null, 'Descriptor de estado eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar descriptor');
        }
    }


}
