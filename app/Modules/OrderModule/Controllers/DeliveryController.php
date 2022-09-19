<?php

namespace App\Modules\OrderModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GuideModule\Guide;
use App\Modules\OrderLogModule\OrderLog;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RouteModule\Controllers\RouteTrait;
use App\Modules\StatusDescriptorModule\StatusDescriptor;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    use RouteTrait;

    protected $path = 'OrderModule.views.html.';
    public function indexOndemand()
    {
        return view($this->path . 'deliveries.index');
    }

    public function indexPacking()
    {
        return view($this->path . 'deliveriesPacking.index');
    }

    public function assignOndemad(Request $request)
    {
        $response = $this->storeRouteOndemand($request);
        if ($response['state'] == 200) {
            // OrderLog::create([
            //     'status_matrix_id' => 3,
            //     'user_id' => Auth::user()->id,
            //     'order_id' => $response['data']->id
            // ]);
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

    public function assignPacking(Request $request)
    {
        $response = $this->storeRoutePacking($request);

        if ($response['state'] == 200) {
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

    public function orderStates()
    {
        $order_states = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_states');
        })->get();
        return $this->respond(200, $order_states, null, 'Estado de las ordenes');
    }

    public function updateStateOrders(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $order->update([
            'status_matrix_id' => $request->state
        ]);
        return $this->respond(200, $order, null, 'Estado de la orden actualizado');
    }

    public function statusMatrix()
    {
        $role_id = Auth()->user()->role;
        $statusMatrix = StatusMatrix::scope(Request()->scope_id)->get();

        $data = $statusMatrix->map(function ($item, $key) use ($role_id) {
            $descriptor = StatusDescriptor::where('status_matrix_id', $item->id)->where('role_id', $role_id)->first();
            if (!is_null($descriptor)) {
                $item->name = $descriptor->description;
            }
            return $item;
        });

        return $this->respond(200, $data, null, 'matriz de estados');
    }

    public function sendOrdersPickupToDelivery(Request $request)
    {
        $statusMatrix = StatusMatrix::with('getScope')->whereHas('getScope', function($query){
            $query->where('name', 'delivery');
        })->get();
        $new_statusMatrix_id = $statusMatrix->where('name', 'POR DESPACHAR')->first();
        foreach ($request->guide_ids as $guide_id) {
            $guides = Guide::find($guide_id)->update([
                'status_matrix_id' => $new_statusMatrix_id->id,
            ]);
        }

        return $this->respond(200, $guides, null, 'Guías enviada a por despachar de entrega');

    }
}
