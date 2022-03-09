<?php

namespace App\Http\Controllers\Admin;

use App\BranchOffice;
use App\Customer;
use App\Department;
use App\Guide;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\OrderTrait;
use App\Order;
use App\ParameterValue;
use App\UserBranch;
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
        $orders = Order::number(request()->number)
            ->order_type(request()->order_type)
            ->customer(request()->name)
            ->date(request()->from, request()->to)
            ->state(request()->state)
            ->get();
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        return view('orders.index', compact('orders', 'order_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $transport_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'transport_type');
        })->get();
        $payment_method = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_method');
        })->get();
        $customers = Customer::with('getUser')->get();
        $customer_document_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'customer_document_type');
        })->get();

        return view('orders.create', compact('customers','order_type','transport_type','payment_method', 'customer_document_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth()->user()->role != 1) {
            $request->merge(['user_id' => Auth()->user()->id]);
        };
        if ($request->urgent_dispatch == 'on') {
            $request->merge(['urgent_dispatch' => 1]);
        } else {
            $request->merge(['urgent_dispatch' => 0]);
        }
        if ($request->return_last_destination == 'on') {
            $request->merge(['return_last_destination' => 1]);
        } else {
            $request->merge(['return_last_destination' => 0]);
        }
        $request->merge(['state' => 1]);
        $response = $this->storeOrder($request);
        if ($response['state'] == 200) {
            if ($request->guideCheck) {
                $assignGuide = $this->assignGuide($request, $response['data']->id);
                if ($assignGuide['state'] != 200) {
                    return redirect()->back()->with('danger', $assignGuide['message']);
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
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $customer_document_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'customer_document_type');
        })->get();

        return view('orders.showFold.show', compact('order', 'order_type', 'customer_document_type'));
    }


    public function historial()
    {
        return view('orders.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::with('getUser', 'getUser.getCustomer', 'getGuides')->find($id);
        $user_id = $order->getUser->id;
        $branches = BranchOffice::with('getBranchUser')->whereHas('getBranchUser', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        $departments = Department::with('getDepartmentUser')->whereHas('getDepartmentUser', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $transport_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'transport_type');
        })->get();
        $payment_method = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_method');
        })->get();
        $customer_document_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'customer_document_type');
        })->get();

        return view('orders.editFold.edit', compact('order', 'branches', 'departments', 'order_type', 'transport_type', 'payment_method', 'customer_document_type'));
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
        if (Auth()->user()->role != 1) {
            $request->merge(['user_id' => Auth()->user()->id]);
        };
        if ($request->urgent_dispatch == 'on') {
            $request->merge(['urgent_dispatch' => 1]);
        } else {
            $request->merge(['urgent_dispatch' => 0]);
        }
        if ($request->return_last_destination == 'on') {
            $request->merge(['return_last_destination' => 1]);
        } else {
            $request->merge(['return_last_destination' => 0]);
        }
        $request->merge(['state' => 1]);
        $response = $this->updateOrder($request->merge(['order_id' => $id]));
        if ($response['state'] == 200) {
            if ($request->guideCheck) {
                $assignGuide = $this->assignGuide($request, $response['data']->id);
                if ($assignGuide['state'] != 200) {
                    return redirect()->back()->with('danger', $assignGuide['error']);
                }
            }
            return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente.');
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
        if ($response['state'] == 200) {
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
            $orders = Order::with('getOrderType')->whereHas('getOrderType', function ($query)  {
                $query->where('name', 'Ondemand');
            })->where('state', $type)
            ->with(['getUser.getCustomer', 'getUser.getDocumentType', 'getGuides.getRoute.getMessenger', 'getPaymentMethod', 'getDepartment', 'getBranchOffice', 'getGuides.getAddress'])
            ->get();

            // $orders = Order::where('order_type', 1)->wh  ere('state', $type)->with(['getUser','getGuides'])->get();
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }



    public function orderNumber()
    {
        //Search Orders
        $orders = Order::get();
        if (count($orders) > 0) {
            $last_order = $orders[count($orders) - 1]->order_number;
            $order_number = explode('_', $last_order)[1];
            $orderNumber = 'Orden_' . ($order_number + 1);
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
    public function record(){
        return view('orders.historial');
    }
}
