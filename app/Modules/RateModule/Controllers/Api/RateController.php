<?php

namespace App\Modules\RateModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\RateModule\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use RestActions;

    public function index()
    {
        try {
            $rates = Rate::packageType(request()->package_type)
                ->baseValue(request()->base_value)
                ->packageType(request()->package_type)
                ->whereZone(request()->zone_id)
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

    public function rateInquiry(Request $request)
    {
        $rate = Rate::whereZone($request->zone_id)->first();
        return $this->respond(200, $rate, null, 'Detalle de la tarifa');
    }

    public function calculatePackingRates(Request $request)
    {
        $model = new Rate();
        $rate_id = $request->rate_id;
        $lbs = $request->lbs;
        $vol = $request->vol;
        $immediate_delivery = $request->immediate_delivery;
        $calculated = $model->calculateRate($rate_id, $lbs, $vol,  $immediate_delivery);
        return $this->respond(200, $calculated, null, 'Calculo de la tarifa');
    }
}
