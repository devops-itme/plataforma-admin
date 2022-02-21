<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DeliveryTrait;
use App\Http\Controllers\Traits\RouteTrait;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use RouteTrait;

    public function assignate(Request $request)
    {
        $response = $this->storeRouteOndemand($request);

        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

}
