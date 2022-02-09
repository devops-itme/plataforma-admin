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
        $orders = Order::get();
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
        if($request->express_delivery == 'on'){$request->merge(['express_delivery' => 1]);}
        else{$request->merge(['express_delivery' => 0]);}
        if($request->last_destination_return == 'on'){$request->merge(['last_destination_return' => 1]);}
        else{$request->merge(['last_destination_return' => 0]);}
        $request->merge(['state' => 1]);
        $response = $this->storeOrder($request);
        if($response['state'] == 200){
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
        return view('orders.editFold.edit');
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
        $response = $this->updateOrder($request->merge(['order_id' => $id]));
        if($response['state'] == 200){
            return json_encode([
                'state' => $response['state'],
                'data' =>$response['data']
            ]);
        } else {
            return json_encode($response['message']);
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
}
