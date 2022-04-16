<?php

namespace App\Modules\OrderModule\Controllers;

use App\Modules\ActivityLogModule\ActivityLog;
use App\Modules\AddressModule\Address;
use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\CustomerModule\Customer;
use App\Modules\DepartmentModule\Department;
use App\Modules\GuideModule\Guide;
use App\Http\Controllers\Controller;
use App\Modules\OrderModule\Controllers\OrderTrait;
use App\Modules\OrderModule\Order, App\OrderLog, App\ParameterValue, App\User, App\UserBranch;
use App\Modules\PickupHourModule\PickupHour;
use App\Modules\ZoneModule\Zone;
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
    protected $path = 'OrderModule.views.html.';
    public function index()
    {
        $orders = Order::number(request()->number)
            ->order_type(request()->order_type)
            ->customer(request()->name)
            ->date(request()->from, request()->to)
            ->state(request()->state)
            ->with('getStatusMatrix')->whereHas('getStatusMatrix', function ($query) {
                $query->where('name', '!=', 'ENTREGADO');
            })->paginate(10);
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        return view($this->path . 'index', compact('orders', 'order_type'));
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
        $zones = Zone::get();

        return view($this->path . 'create', compact('customers', 'order_type', 'transport_type', 'payment_method', 'customer_document_type', 'zones'));
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
        $request->merge([
            'state' => 1, 'address_id' => $request->customer_address, 'description' => $request->description_order,
            'creator_user_id' => Auth::user()->id,
        ]);
        $response = $this->storeOrder($request);
        if ($response['state'] == 200) {
            if ($request->guideCheck) {
                $assignGuide = $this->assignGuide($request, $response['data']->id);
                if ($assignGuide['state'] != 200) {
                    return redirect()->back()->with('danger', $assignGuide['message']);
                }
            }
            
            return redirect()->route('orders.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
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
        $user_id = $order->getUser->id ?? NULL;
        $customer_document_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'customer_document_type');
        })->get();
        $payment_method = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_method');
        })->get();
        $transport_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'transport_type');
        })->get();
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $branches = BranchOffice::with('getBranchUser')->whereHas('getBranchUser', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        $departments = Department::with('getDepartmentUser')->whereHas('getDepartmentUser', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        $customer_addresses = Address::with('getUser')->whereHas('getUser', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        $zones = Zone::get();
        return view($this->path . 'show.index', compact('order', 'order_type', 'customer_document_type', 'payment_method', 'transport_type', 'order_type', 'branches', 'departments', 'customer_addresses', 'zones'));
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
        $customer_addresses = Address::with('getUser')->whereHas('getUser', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        $zones = Zone::get();

        return view($this->path . 'edit.index', compact('order', 'branches', 'departments', 'order_type', 'transport_type', 'payment_method', 'customer_document_type', 'customer_addresses', 'zones'));
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
        $request->merge(['state' => 1, 'address_id' => $request->customer_address, 'description' => $request->description_order]);
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
            $matriz_id = $type != 5 ?  $matriz_id = [$type] : $matriz_id = [5, 6];


            $orders = Order::with('getOrderType')->whereHas('getOrderType', function ($query) {
                $query->where('name', 'Ondemand');
            })->whereIn('status_matrix_id', $matriz_id)
                ->with(['getUser.getCustomer', 'getUser.getDocumentType', 'getGuides.getRoute.getMessenger', 'getPaymentMethod', 'getDepartment', 'getBranchOffice', 'getGuides'])
                ->get();

            // $orders = Order::where('order_type', 1)->wh  ere('state', $type)->with(['getUser','getGuides'])->get();
            return $this->respond(200, $orders, null, 'Lista de ordenes');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function porDespacharOndemand($id)
    {
        try {
            $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
                $query->where('name', 'order_types');
            })->get();

            $order = Order::where('id', $id)->where('order_type', $order_type[0]->id)->update([
                'status_matrix_id' => 3
            ]);
            return $this->respond(200, [], null, 'Estado actualizado');
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
    public function record()
    {
        $orders = Order::with('getStatusMatrix')->whereHas('getStatusMatrix', function ($query) {
            $query->where('name', 'ENTREGADO');
        })->number(request()->number)
            ->order_type(request()->order_type)
            ->customer(request()->name)
            ->date(request()->from, request()->to)
            ->with('getUser')->get();
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        return view($this->path . 'historial', compact('orders', 'order_type'));
    }
}
