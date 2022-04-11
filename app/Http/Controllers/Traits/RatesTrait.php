<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions;
use App\Rate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait RatesTrait
{
    use RestActions;

    public function validateRate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'zone_id' => 'required|exists:zones,id',
                'neighborhood_id' => 'required|exists:neighborhoods,id',
                'package_type' => 'required|exists:parameter_values,id',
                'estimated_time' => 'required|numeric',
                'base_value' => 'required|numeric',
                'extra_for_weight' => 'required|numeric',
                'extra_per_size' => 'required|numeric',
                'percentage_immediate_delivery' => 'required|numeric',
                'special_rate' => 'nullable|numeric',
                'state' => 'nullable|numeric',
            ]
        );
    }

    public function saveRate($request)
    {
        $validator = $this->validateRate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $rate = Rate::create([
                'zone_id' => $request->zone_id,
                'neighborhood_id' => $request->neighborhood_id,
                'package_type' => $request->package_type,
                'estimated_time' => $request->estimated_time,
                'base_value' => $request->base_value,
                'extra_for_weight' => $request->extra_for_weight,
                'extra_per_size' => $request->extra_per_size,
                'percentage_immediate_delivery' => $request->percentage_immediate_delivery,
                'special_rate' => $request->special_rate ?? 0,
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $rate, null, 'Tarifa creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear tarifa');
        }
    }

    public function updateRate($request, $id)
    {
        $validator = $this->validateRate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $rate = Rate::find($id);
            if (is_null($rate)) {
                return $this->respond(500, [], 'rate not found', 'No se encontró la tarifa');
            }
            $rate->update([
                'zone_id' => $request->zone_id,
                'neighborhood_id' => $request->neighborhood_id,
                'package_type' => $request->package_type,
                'estimated_time' => $request->estimated_time,
                'base_value' => $request->base_value,
                'extra_for_weight' => $request->extra_for_weight,
                'extra_per_size' => $request->extra_per_size,
                'percentage_immediate_delivery' => $request->percentage_immediate_delivery,
                'special_rate' => $request->special_rate ?? 0,
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $rate, null, 'Tarifa actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar tarifa');
        }
    }

    public function deleteRate($id)
    {
        try {
            $rate = Rate::find($id);
            if (is_null($rate)) {
                return $this->respond(500, [], 'rate not found', 'No se encontró la tarifa');
            }
            $rate->delete();
            return $this->respond(200, $rate, null, 'Tarifa eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar tarifa');
        }
    }
}
