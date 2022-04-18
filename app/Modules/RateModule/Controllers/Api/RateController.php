<?php

namespace App\Modules\RateModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\RateModule\Rate;

class RateController extends Controller
{
    use RestActions;

    public function index()
    {
        try {
            $rates = Rate::packageType(request()->package_type)
                ->baseValue(request()->base_value)
                ->packageType(request()->package_type)
                ->zone(request()->zone_id)
                ->neighborhood(request()->neighborhood_id)
                ->state(request()->state)
                ->get();

            return $this->respond(200, $rates, null, 'Lista de tarifas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function show($rate_id)
    {
        try {
            $rate = Rate::find($rate_id);
            return $this->respond(200, $rate, null, 'Detalle de la tarifa');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
