<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\ParameterValue;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ReportTrait
{
    use TraitsRestActions;

    public function reportsValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'state' => 'required',
            ]
        );
    }
    public function getReports()
    {
        try {
            $reports = Report::get();
            return $this->respond(200, $reports);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showReport($id)
    {
        try {
            $report = Report::where('id', $id)->first();
            return $this->respond(200, $report);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function saveReport($request)
    {
        $validator = $this->reportsValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {
            $report = Report::create([
                $request->all()
            ]);
            return $this->respond(200, $report, null, 'Reporte creado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear reporte');
        }
    }
    public function updateReport($request, $id)
    {
        try {
            $validator = $this->reportsValidate($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
            }
            $report = Report::find($id);
            $report->update($request->all());

            return $this->respond(200, $report, null, 'Reporte actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar reporte');
        }
    }
    public function deleteReport($id)
    {
        try {
            $report = Report::find($id);
            $report->delete();
            return $this->respond(200, $report, null, 'Reporte eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar reporte');
        }
    }
}
