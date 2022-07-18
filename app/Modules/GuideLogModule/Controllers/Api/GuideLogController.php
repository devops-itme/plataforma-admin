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
            return $this->respond(500, $request->all(), null, 'Log test');
            $GuideLog = new GuideLog();
            return $GuideLog->saveGuideLog($request);
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
