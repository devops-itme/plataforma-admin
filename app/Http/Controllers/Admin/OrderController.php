<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\OrderTrait;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use OrderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::
            number(request()->number)
            ->service_type(request()->service_type)
            ->customer(request()->customer)
            ->date(request()->from, request()->to)
            ->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::with('getUser')->get();
        return view('orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth()->user()->role != 1){
            $request->merge(['user_id' => Auth()->user()->id]);
        };
        if($request->urgent_dispatch == 'on'){$request->merge(['urgent_dispatch' => 1]);}
        else{$request->merge(['urgent_dispatch' => 0]);}
        if($request->return_last_destination == 'on'){$request->merge(['return_last_destination' => 1]);}
        else{$request->merge(['return_last_destination' => 0]);}
        $request->merge(['state' => 1]);
        $response = $this->storeOrder($request);
        if($response['state'] == 200){
            if($request->guideCheck){
                $assignGuide = $this->assignGuide($request, $response['data']->id);
                if($assignGuide['state'] != 200){
                    return redirect()->back()->with('danger', $assignGuide['error']);
                }
            }
            return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
        } else {
            return redirect()->back()->with('danger', $response['error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('getUser')->find($id);
        return view('orders.showFold.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $customers = Customer::with('getUser')->get();
        return view('orders.editFold.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth()->user()->role != 1){
            $request->merge(['user_id' => Auth()->user()->id]);
        };
        if($request->express_delivery == 'on'){$request->merge(['express_delivery' => 1]);}
        else{$request->merge(['express_delivery' => 0]);}
        if($request->last_destination_return == 'on'){$request->merge(['last_destination_return' => 1]);}
        else{$request->merge(['last_destination_return' => 0]);}
        $request->merge(['state' => 1]);

        $response = $this->updateOrder($request->merge(['order_id' => $id]));
        if($response['state'] == 200){
            return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->deleteOrder($id);
        if($response['state'] == 200){
            return json_encode([
                'state' => $response['state'],
                'Message' => 'Eliminación exitosa'
            ]);
        } else {
            return json_encode($response['message']);
        }
    }

    public function ordersForDelivery($type)
    {
        try {
            $orders = Order::where('order_type', $type)->with(['getUser','getGuides'])->get();
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function orderNumber()
    {
        //Search Orders
        $orders = Order::get();
        if(count($orders) > 0){
            $last_order = $orders[count($orders) - 1]->order_number;
            $order_number = explode('_', $last_order)[1];
            $orderNumber = 'Orden_'.($order_number + 1);
            return json_encode([
                'state' => 200,
                'data' => $orderNumber,
            ]);
        } else {
            return json_encode([
                'state' => 200,
                'data' => 'Orden_1',
            ]);
        }
    }
}
