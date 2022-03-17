<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PickupHourTrait;
use App\ParameterValue;
use App\PickupHour;
use Illuminate\Http\Request;

class PickupHourController extends Controller
{
    use PickupHourTrait;

    public function index()
    {
        try {
            $pickup_days = PickupHour::with('getDay')->get();

            return $this->respond(200, $pickup_days, null, 'Horas registradas');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error');
        }
    }

    public function store($request)
    {
        $response = $this->storePickupHour($request);
        return $response;
    }

    public function update($id, Request $request)
    {
        $response = $this->updatePickUpHour($id, $request);
        return $response;
    }

    public function destroy($id)
    {
        $response = $this->deletePickupHour($id);
        if($response['state'] == 200){
            return redirect()->route('hours.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
