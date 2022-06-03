<?php

namespace App\Modules\ParameterValueModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParametersModule\Parameter;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
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

    public function getStatusMatrix(Request $request)
    {
        try {
            $scope_id = $request->scope_id;
            $scope = StatusMatrix::where('scope_id', $scope_id);
            if (is_null($scope)) {
                return $this->respond(500, [], 'not found', 'El ámbito no existe');
            }
            $status_matrix = $scope->get(['id', 'name']);
            return $this->respond(200, $status_matrix, null, 'Matriz de estados');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function getIssues(Request $request)
    {
        try {
            $status_matrix_id = $request->status_matrix_id;
            $issues_array = StatusMatrix::where('id', $status_matrix_id)->first(['issues']);
            if (is_null($issues_array)) {
                return $this->respond(500, [], 'not found', 'No se encontraron incidencias');
            }
            
            $issues_array = explode(",", str_replace(']"}', "", str_replace('{"issues":"[', "", $issues_array)));
            $issues = ParameterValue::whereIn('id', $issues_array)->get(['id', 'name']);
            
            return $this->respond(200, $issues, null, 'Incidencias');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
