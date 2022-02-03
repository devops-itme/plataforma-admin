<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\MyService;
use App\ParameterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait MyServiceTrait
{
    use TraitsRestActions;

    public function myServiceValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'user_id'=> 'nullable',
                'state' => 'nullable',

            ]
        );
    }
    public function getMyServices()
    {
        try {
            $myService = MyService::get();
            return $this->respond(200, $myService);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showMyService($id)
    {
        try {
            $myService = MyService::where('id', $id)->first();
            return $this->respond(200, $myService);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function saveMyService($request)
    {
        $validator = $this->myServiceValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {
            $myService = MyService::create($request->all());
            return $this->respond(200, $myService, null, 'Servicio creado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear servicio');
        }
    }
    public function updateMyService($request, $id)
    {
        try {
            $validator = $this->myServiceValidate($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
            }
            $myService = MyService::find($id);
            $myService->update($request->all());

            return $this->respond(200, $myService, null, 'Servicio actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar servicio');
        }
    }
    public function deleteMyService($id)
    {
        try {
            $myService = MyService::find($id);
            $myService->delete();
            return $this->respond(200, $myService, null, 'Servicio eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar servicio');
        }
    }
}
