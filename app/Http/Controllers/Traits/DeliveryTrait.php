<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Messenger;
use App\Order;
use App\ParameterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait DeliveryTrait
{
    use TraitsRestActions;


    // public function getOrders($type)
    // {
    //     try {
    //         $orders = Order::where('service_type_id', $type)->with(['getUser','getGuides'])->get();
    //         return $this->respond(200, $orders);
    //     } catch (\Throwable $e) {
    //         return $this->respond(500, [], $e->getMessage());
    //     }
    // }

    // public function getMessengers()
    // {
    //     try {
    //         $messengers = Messenger::with(['user'])->get();
    //         return $this->respond(200, $messengers);
    //     } catch (\Throwable $e) {
    //         return $this->respond(500, [], $e->getMessage());
    //     }
    // }







}
