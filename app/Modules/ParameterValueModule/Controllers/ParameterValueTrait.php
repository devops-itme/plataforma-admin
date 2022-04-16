<?php

namespace App\Modules\ParameterValueModule\Controllers;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ParameterValueTrait
{
    use RestActions;

    public function validateParameter($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'description' => 'nullable|string',
                'state' => 'nullable',
                'parameter_id' => [
                    Rule::requiredIf($action == 'create')
                ]
            ]
        );
    }

    public function storeParameterValue($request)
    {
        $validator = $this->validateParameter($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $parameter = ParameterValue::create([
                'name' => $request->name,
                'description' => $request->description,
                'parameter_id' => $request->parameter_id,
                'state' => 1
            ]);

            return $this->respond(200, $parameter, null, 'Parámetro creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear parámetro');
        }
    }

    public function updateParameterValue($id, $request)
    {
        $validator = $this->validateParameter($request, 'update', $id);
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $parameter = ParameterValue::find($id);
            if(is_null($parameter)){
                return $this->respond(500, [], 'user not found', 'No se encontró el parámetro');
            }
            $parameter->update([
                'name' => $request->name,
                'description' => $request->description,
                'state' => $request->state
            ]);

            return $this->respond(200, $parameter, null, 'parámetro actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear parámetro');
        }
    }

    public function deleteParameterValue($id)
    {
        try {
            $parameter = ParameterValue::find($id);
            if (is_null($parameter)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el parámetro');
            }
            $parameter->delete();
            return $this->respond(200, $parameter, null, 'Parámetro eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar parámetro');
        }
    }
}
