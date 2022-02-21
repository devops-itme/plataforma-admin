<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DeliveryTrait;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use DeliveryTrait;

    public function assignate(Request $request)
    {
        $response = $this->guideAssignment($request);
        $response = $response['data'];
        // return $messengers;
        return $this->respond(200, $response, null, 'Guia asignada');
    }

}
