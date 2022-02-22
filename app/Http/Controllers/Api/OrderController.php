<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Order;
use App\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use RestActions;

    public function index(Request $request)
    {
        $messenger_user_id = $request->messenger_user_id ?? Auth::user()->id;

        try {
            $orders = Order::whereHas('getGuides', function (Builder $query) use ($messenger_user_id) {
                $query->whereHas('getRoute', function (Builder $query) use ($messenger_user_id) {
                    $query->where('messenger_user_id', $messenger_user_id);
                });
            })->get();
            return $this->respond(200, $orders, null, 'Ordenes asignadas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
