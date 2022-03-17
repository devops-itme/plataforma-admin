<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions;
use App\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait PlansTrait
{
    use RestActions;

    public function validatePlans($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', Rule::unique('plans', 'name')->ignore($id)],
                'description' => 'nullable|string',
                'state' => 'nullable|numeric',
            ]
        );
    }

    public function storePlans($request)
    {
        $validator = $this->validatePlans($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $plan = Plan::create([
                'name' => $request->name,
                'description' => $request->description,
                'state' => $request->state
            ]);

            return $this->respond(200, $plan, null, 'Plan creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear plan');
        }
    }

    public function updatePlans($id, $request)
    {
        $validator = $this->validatePlans($request, 'update', $id);
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $plan = Plan::find($id);
            if(is_null($plan)){
                return $this->respond(500, [], 'Plan not found', 'No se encontró el plan');
            }
            $plan->update([
                'name' => $request->name,
                'description' => $request->description,
                'state' => $request->state
            ]);

            return $this->respond(200, $plan, null, 'Plan actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar plan');
        }
    }

    public function deletePlan($id)
    {
        try {
            $plan = Plan::find($id);
            if(is_null($plan)){
                return $this->respond(500, [], 'Plan not found', 'No se encontró el plan');
            }
            $plan->delete();

            return $this->respond(200, [], null, 'Plan eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar plan');
        }
    }
}
