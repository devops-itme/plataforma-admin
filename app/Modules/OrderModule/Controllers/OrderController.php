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
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\PickupHourModule\PickupHour;
use App\Modules\RateModule\Rate;
use App\Modules\StatusMatrixModule\StatusMatrix;
use App\Modules\ZoneModule\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            ->whereOrderType(request()->order_type)
            ->customer(request()->name)
            ->date(request()->from, request()->to)
            ->whereStatusMatrix([request()->state])
            ->with('getStatusMatrix')->whereHas('getStatusMatrix', function ($query) {
                $query->where('name', '!=', 'RECOGIDO')
                ->where('name', '!=', 'ENTREGADO');
               
            })
            ->national();

        if (Auth::user()->getRole->name != 'Admin') {
            $orders = $orders->whereCustomer(Auth::user()->id);
        }
        $orders = $orders->paginate(10);

        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        $status_matrix = StatusMatrix::get();
        return view($this->path . 'national.index', compact('orders', 'order_type', 'status_matrix'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order_type = ParameterValue::whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })
            ->where('name', '<>', 'International')
            ->get();

        $customers = Customer::whereHas('getUser', function ($query) {
            $query->whereHas('getRole', function ($query) {
                $query->where('name', 'Cliente');
            });
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

        $zones = Zone::get();
        $rates = Rate::get();
        /* dd($rates); */
        $customer_addresses = [];
        $tax_percentage = 7;
        return view($this->path . 'national.create', compact('customers', 'order_type', 'transport_type', 'payment_method', 'customer_document_type', 'zones', 'rates', 'customer_addresses', 'tax_percentage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|numeric|exists:addresses,id',
            'guides' => 'required',
            'vehicle_type_id' => 'required',
            'order_type' => 'required',
            'user_id' => 'required',
            'schedule_date' => 'required',
            'schedule_time_range' => 'required',
            'order_description' => 'required' 
        ]); 
        $validator = Validator::make(
            $request->all(),
            [
                'address_id' => 'required|numeric|exists:addresses,id',
                'guides' => 'required',
                'vehicle_type_id' => 'required',
                'order_type' => 'required',
                'user_id' => 'required',
                'schedule_date' => 'required',
                'schedule_time_range' => 'required',
                'order_description' => 'required' 
                /* 'guide_address' => 'required', */
                /* 'phone_contact' => 'required',
                'contact' => 'required' */

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('danger', $validator->errors()->first());
        }

        $Order = new Order();
        $order_number = $Order->generateOrderNumber()['data'];
        $request->merge([
            'order_number' => $order_number,
            'guides' => json_decode($request->guides),
            'urgent_dispatch' => $request->urgent_dispatch == 'on' ? 1 : 0,
            'return_last_destination' => $request->return_last_destination == 'on' ? 1 : 0,
            'state' => 1,
            'description' => $request->order_description,
            'creator_user_id' => Auth::user()->id,
        ]);

        if (Auth()->user()->role != 1) {
            $request->merge(['user_id' => Auth()->user()->id]);
        };

        $response = $Order->createOrderWithGuides($request);
        if ($response['state'] == 200) {
            return redirect()->route('orders.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message'] . ' ' . $response['error']);
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
        $rates = Rate::get();
        return view($this->path . 'show.index', compact('order', 'order_type', 'customer_document_type', 'payment_method', 'transport_type', 'order_type', 'branches', 'departments', 'customer_addresses', 'zones', 'rates'));
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
        $order = Order::find($id);

        $customers = Customer::whereHas('getUser', function ($query) {
            $query->whereHas('getRole', function ($query) {
                $query->where('name', 'Cliente');
            });
        })->get();

        $order_type = ParameterValue::whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })
            ->where('name', '<>', 'International')
            ->get();

        $transport_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'transport_type');
        })->get();

        $user_id = $order->getUser->id;


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
        $rates = Rate::get();
        return view($this->path . 'national.edit', compact('customers', 'order', 'order_type', 'transport_type', 'payment_method', 'customer_document_type', 'customer_addresses', 'zones', 'rates'));
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
        $request->merge(['description' => $request->order_description]);
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
            return redirect()->back()->with('danger', $response['message'] . $response['error']);
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
            $Order = new Order();
            return $Order->updateStatusMatrix($id, new Request(array('status_matrix_id' => 3)));
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function record()
    {
        $orders = Order::with('getStatusMatrix')->whereHas('getStatusMatrix', function ($query) {
            $query->where('name', 'ENTREGADO')
            ->orWhere('name', 'RECOGIDO');
        })->number(request()->number)
            ->whereOrderType(request()->order_type)
            ->customer(request()->name)
            ->date(request()->from, request()->to)
            ->whereStatusMatrix([request()->state])
            ->with('getUser')->get();
        $order_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'order_types');
        })->get();
        return view($this->path . 'historial', compact('orders', 'order_type'));
    }

    public function getOrder($id)
    {
        $Order = new Order();
        return $Order->showOrder($id);
    }

    // mostrar guía del modal
    public function showModGuide($id)
    {
        $guide = Guide::find($id);
        
        return view($this->path . 'national.showGuide', compact('guide'));
    }
}
