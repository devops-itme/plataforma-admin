<?php

namespace App\Modules\PickupHourModule\Controllers;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\PickupHourModule\PickupHour;
use Illuminate\Support\Facades\Validator;

trait PickupHourTrait
{
    use RestActions;


    public function validatePickupTrait($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'day' => 'required|numeric',
                'from' => 'required|regex:/(\d+\:\d+)/',
                'to' => 'required|regex:/(\d+\:\d+)/ |after:from'
            ]
        );
    }

    public function storePickupHour($request)
    {
        $validator = $this->validatePickupTrait($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $hour = PickupHour::create([
                'day_id' => $request->day,
                'init_time' => $request->from,
                'end_time' => $request->to
            ]);

            return $this->respond(200, $hour, null, 'Hora registrada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al registrar la hora');
        }
    }

    public function updatePickUpHour($id, $request)
    {
        $validator = $this->validatePickupTrait($request, 'update', $id);
        if ($validator->fails()) {
            return $this->respond(500, $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $hour = PickupHour::find($id);
            if(is_null($hour)){
                return $this->respond(500, [], 'register not found', 'No se encontró el registro');
            }
            $hour->update([
                'day_id' => $request->day,
                'init_time' => $request->from,
                'end_time' => $request->to
            ]);
            return $this->respond(200, $hour, null, 'Registro actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar registro');
        }
    }

    public function deletePickupHour($id)
    {
        try {
            $hour = PickupHour::find($id);
            if (is_null($hour)) {
                return $this->respond(500, [], 'hour not found', 'No se encontró el registro de hora');
            }
            $hour->delete();
            return $this->respond(200, $hour, null, 'Registro de hora eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar registro de hora');
        }
    }

    public function getPickupHours()
    {
        try {
            $pickup_days = PickupHour::with('getDay')->get();

            $pickup_days = $pickup_days->groupBy(function ($item, $key){
                return $item->getDay->name;
            });

            return $this->respond(200, $pickup_days, null, 'Horas registradas');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error');
        }
    }

}
