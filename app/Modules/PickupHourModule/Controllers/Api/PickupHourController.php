<?php

namespace App\Modules\PickupHourModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\PickupHourModule\Controllers\PickupHourTrait;
use Illuminate\Http\Request;

class PickupHourController extends Controller
{
    use PickupHourTrait;

    public function index()
    {
        $response = $this->getPickupHours();
        return $response;
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
