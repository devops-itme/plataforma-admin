<?php

namespace App\Modules\ServiceTypeModule\Controllers;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\ServiceTypeModule\ServiceType;
use Illuminate\Support\Facades\Validator;

trait ServiceTypeTrait
{
    use RestActions;

    public function serviceTypeValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'state' => 'nullable',
            ]
        );
    }
    public function getServiceTypes()
    {
        try {
            $serviceType = ServiceType::get();
            return $this->respond(200, $serviceType);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showServiceType($id)
    {
        try {
            $serviceTypes = ServiceType::where('id', $id)->first();
            return $this->respond(200, $serviceTypes);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function saveServiceType($request)
    {
        $validator = $this->serviceTypeValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {
            $serviceType = ServiceType::create($request->all());
            return $this->respond(200, $serviceType, null, 'Tipo de servicio creado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear tipo de servicio');
        }
    }
    public function updateServiceType($request, $id)
    {
        try {
            $validator = $this->serviceTypeValidate($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
            }
            $serviceType = ServiceType::find($id);
            $serviceType->update($request->all());

            return $this->respond(200, $serviceType, null, 'Tipo de servicio actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar tipo de servicio');
        }
    }
    public function deleteServiceType($id)
    {
        try {
            $report = ServiceType::find($id);
            $report->delete();
            return $this->respond(200, $report, null, 'Tipo de servicio eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar tipo de servicio');
        }
    }
}
