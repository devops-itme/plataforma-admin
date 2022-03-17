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
            $pickupdays = PickupHour::with('getDay')->get();
            $days = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
                $query->where('name', 'days');
            })->get();

            return $this->respond(200, $pickupdays, null, 'Horas registradas');
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
