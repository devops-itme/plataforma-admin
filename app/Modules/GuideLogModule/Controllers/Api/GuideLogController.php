<?php

namespace App\Modules\GuideLogModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuideLogModule\GuideLog;
use Illuminate\Http\Request;

class GuideLogController extends Controller
{
    use RestActions;
    public function index(Request $request)
    {
        try {
            $GuideLog = new GuideLog();
            return $GuideLog->getGuideLogs($request);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function store(Request $request)
    {
        try {
            $GuideLog = new GuideLog();
            return $GuideLog->saveGuideLog($request);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function obtainGuideLogs(Request $request)
    {
        try {
            $guide_log = $request->guide_log;
            $log = GuideLog:: with(['getState',
            'getGuide.getOrder.getUser.getCustomer',
            'getGuide.getTransportType',
            'getGuide.getOrder.getOrderType',
            'getGuide.getBranchOffice.getDepartment.getDepartment'
        ])->where('guide_id', $guide_log)->get();

            if (is_null($log)) {
                return $this->respond(500, [], 'not found', 'El Log no existe');
            }
            return $this->respond(200, $log, null, 'Log de Guias');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function updateGuideLog(Request $request)
    {
        try {
            // $guide = Guide::findOrFail($request->id);
            // $guide->update([
            //     'additional_address' => $request->additional_address,
            //     'additional_email' => $request->additional_email,
            //     'additional_phone' => $request->additional_phone,
            //     'address_name' => $request->address,
            //     'app_status' => $request->app_status,
            //     'concept' => $request->concept,
            //     'contact' => $request->contact,
            //     'email_contact' => $request->contact_email,
            //     'phone_contact' => $request->contact_phone,
            //     'customer_document_type' => $request->document_type,
            //     'transport_type' => $request->transport_type,
            //     'value' => $request->value,
            //     'value_corp' => $request->corp_value,
            //     'novelty' => $request->novelty
            // ]);

            // $guide_id = $guide->order_id;
            $guide_log = GuideLog::where('id','202')->findOrFail();

            $guide_log->update([
             'issue_id' => '58',
         ]);

            return $this->respond(200,$guide_log,'Log de Guía actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar el log de guía');
        }
    }
}
