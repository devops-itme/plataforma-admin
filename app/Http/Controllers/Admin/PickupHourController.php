<?php

namespace App\Http\Controllers\Admin;

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
        $pickupdays = PickupHour::with('getDay')->get();
        $days = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'days');
        })->get();
        return view('Hours.index', compact('days', 'pickupdays'));
    }

    public function edit($id)
    {
        $hour = PickupHour::find($id);
        if(!is_null($hour)){
            return $this->respond(200, $hour, '', '');
        }else {
            return $this->respond(500, [], 'data not found', 'No se encontró la información.');
        }
    }

    public function store(Request $request)
    {
        $response = $this->storePickupHour($request);
        if($response['state'] == 200){
            return redirect()->route('hours.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
    }

    public function update($id, Request $request)
    {
        $response = $this->updatePickUpHour($id, $request);
        if($response['state'] == 200){
            return redirect()->route('hours.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
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

    public function pickupHours()
    {
        $response = $this->getPickupHours();
        return $response;
    }
}
