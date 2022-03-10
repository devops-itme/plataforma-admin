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
            ]
        );
    }

    public function storeParameter($request)
    {
        $validator = $this->validateParameter($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
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

    public function deleteParameter($id)
    {
        try {
            $parameter = Parameter::find($id);
            if (is_null($parameter)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el parametro');
            }
            $parameterValues = ParameterValue::where('parameter_id', $id)->get();
            if(!is_null($parameterValues)) {
                foreach ($parameterValues as $child) {
                    $child->delete();
                }
            }
            $parameter->delete();
            return $this->respond(200, $parameter, null, 'Parametro eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar parametro');
        }
    }
}
