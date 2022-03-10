<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Parameter;
use App\ParameterValue;
use Illuminate\Http\Request;

class ParameterValueController extends Controller
{
    use RestActions;
    public function getParameterValues(Request $request)
    {
        try {
            $parameter_name = $request->parameter_name;
            $parameter = Parameter::where('name', $parameter_name)->first();
            if (is_null($parameter)) {
                return $this->respond(500, [], 'not found', 'El parámetro no existe');
            }
            $parameter_id = $parameter->id;
            $parameter_values = ParameterValue::where('parameter_id', $parameter_id)->get(['id', 'name']);
            return $this->respond(200, $parameter_values, null, 'Valores de ' . $parameter_name);
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
