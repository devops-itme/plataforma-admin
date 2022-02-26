<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Http\Resources\OrderResource;
use App\Order;
use App\ParameterValue;
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
        $relationships = [
            'getUser', 'getUser.getDocumentType',
            'getOrderType', 'getDocumentType', 'getPaymentMethod',
            'getState', 'getDepartment', 'getBranchOffice'
        ];
        try {
            $state = ParameterValue::where('name', 'Despachados')->first();
    
            $orders = Order::whereHas('getGuides', function (Builder $query) use ($messenger_user_id) {
                $query->whereHas('getRoute', function (Builder $query) use ($messenger_user_id) {
                    $query->where('messenger_user_id', $messenger_user_id);
                });
            })
                ->where('state', $state->id)
                ->with($relationships)->get();
            $orders = OrderResource::collection($orders);
            return $this->respond(200, $orders, null, 'Ordenes asignadas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
