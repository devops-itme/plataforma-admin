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
            'getUserLog',
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
}
