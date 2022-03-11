<?php

namespace App\Http\Controllers\Traits;

use App\Guide;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Order;
use App\ParameterValue;
use App\Route;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


trait RouteTrait
{
    use RestActions;

    public function RouteValidate($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id' => [$action == 'create' ? 'confirmed' : 'nullable',
                    Rule::requiredIf($action == 'create'), 'exists:guides,id'
                ],
                'messenger_user_id' => 'required|exists:users,id',
                'date' => 'nullable|date'
            ]
        );
    }

    public function storeRoute($request)
    {
        $validator = $this->RouteValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' , $validator->errors()->first());
        }
        try {
            $route = Route::create([
                'guide_id' => $request->guide_id,
                'messenger_user_id' => $request->messenger_user_id,
                'date' => $request->date
            ]);
            return $this->respond(200, $route, null, 'Ruta creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear la ruta');
        }
    }

    public function storeRouteOndemand($request)
    {

        $validator = $this->RouteValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' , $validator->errors()->first());
        }
        try {
            $dispatch_code = strtotime(Carbon::now());

            $order = Order::where('id', $request->order_id)->with('getGuides')->first();
            $guides = $order->getGuides;
            foreach ($guides as $guide) {
                $route = Route::create([
                    'guide_id' => $guide->id,
                    'messenger_user_id' => $request->messenger_user_id,
                    'date' => $request->date
                ]);
            }

            $order->update([
                'status_matrix_id'=>$request->state,
                'dispatched'=>$dispatch_code
            ]);

            return $this->respond(200, $order, null, 'Orden asignada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() , 'Error al crear la ruta');
        }
    }

    public function storeRoutePacking($request)
    {

        $validator = $this->RouteValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' , $validator->errors()->first());
        }
        try {
            $dispatch_code = strtotime(Carbon::now());
            $guides = $request->guides;
            foreach ($guides as $guide) {

                $route = Route::create([
                    'guide_id' => $guide['id'],
                    'messenger_user_id' => $request->messenger_user_id,
                    'date' => $request->date
                ]);


                $route = Guide::where('id', $guide['id'])->update([
                    'status_matrix_id' => $request->state_order,
                    'dispatched'=>$dispatch_code
                ]);
            }

            return $this->respond(200, $route, null, 'Orden asignada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() , 'Error al crear la ruta');
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
                return $this->respond(500, [], 'user not found', 'No se encontró la ruta');
            }
            $route->update([
                'guide_id' => $request->guide_id,
                'messenger_user_id' => $request->messenger_user_id,
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
                return $this->respond(500, [], 'user not found', 'No se encontró la ruta');
            }
            $route->delete();
            return $this->respond(200, $route, null, 'Ruta eliminada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar la ruta');
        }
    }
}
