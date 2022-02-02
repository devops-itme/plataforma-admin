<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Route;

trait RouteTrait
{
    use RestActions;

    public function RouteValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id ' => 'required|exists:guides,id',
                'messenger_id ' => 'required|exists:messengers,id',
                'date' => 'nullable|date'
            ]
        );
    }

    public function storeRoute($request)
    {
        $validator = $this->RouteValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }
        try {
            $route = Route::create([
                'guide_id' => $request->guide_id,
                'messenger_id' => $request->messenger_id,
                'date' => $request->date
            ]);
            return $this->respond(200, $route, null, 'Ruta creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear la ruta');
        }
    }

    public function updateRoute($request)
    {
        $validator = $this->RouteValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $route = Route::find($request->route_id);
            if (is_null($route)) {
                return $this->respond(500, [], 'user not found', 'No se encontro la ruta');
            }
            $route->update([
                'guide_id ' => $request->guide_id,
                'messenger_id' => $request->messenger_id,
                'date' => $request->date
            ]);
            return $this->respond(200, $route, null, 'Ruta actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar la ruta');
        }
    }

    public function deleteRoute($id)
    {
        try {
            $route = Route::find($id);
            if (is_null($route)) {
                return $this->respond(500, [], 'user not found', 'No se encontro la ruta');
            }
            $route->delete();
            return $this->respond(200, $route, null, 'Ruta eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar la ruta');
        }
    }
}
