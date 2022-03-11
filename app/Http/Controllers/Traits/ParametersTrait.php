<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions;
use App\Parameter;
use App\ParameterValue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ParametersTrait
{
    use RestActions;

    public function validateParameter($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => [
                    'required', 'string',
                    Rule::unique('parameters', 'name')->ignore($id)->whereNull('deleted_at')
                ],
                'description' => 'nullable|string',
                'state' => 'nullable'
            ]
        );
    }

    public function storeParameter($request)
    {
        $validator = $this->validateParameter($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $parameter = Parameter::create([
                'name' => $request->name,
                'description' => $request->description,
                'state' => 1
            ]);

            return $this->respond(200, $parameter, null, 'Parametro creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear parametro');
        }
    }

    public function updateParameter($id, $request)
    {
        $validator = $this->validateParameter($request, 'update', $id);
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $parameter = ParameterValue::find($id);
            if(is_null($parameter)){
                return $this->respond(500, [], 'user not found', 'No se encontró el parametro');
            }
            $parameter->update([
                'name' => $request->name,
                'description' => $request->description,
                'state' => $request->state
            ]);

            return $this->respond(200, $parameter, null, 'Parametro actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear parametro');
        }
    }

    public function deleteParameter($id)
    {
        try {
            $parameter = ParameterValue::find($id);
            if (is_null($parameter)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el parametro');
            }
            $parameter->delete();
            return $this->respond(200, $parameter, null, 'Parametro eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar parametro');
        }
    }
}
