<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DeliveryTrait;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use DeliveryTrait;

    public function orders($type)
    {
        $orders = $this->getOrders($type);
        $orders = $orders['data'];
        // return $orders;
        return $this->respond(200, $orders, null, 'Lista de ordenes');
    }
}
