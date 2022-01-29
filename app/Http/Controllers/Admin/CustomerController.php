<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\ParameterValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use App\Http\Controllers\Traits\CustomerTrait;

class CustomerController extends Controller
{
    use CustomerTrait, UserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = ParameterValue::where('parameter_id', 1)->get();
        return view('customers.create', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saveUserData = $this->saveUser($request->merge(['role' => 5, 'state' => 1]));
        if($saveUserData['state'] != 200){
            return redirect()->back()->with('danger', $saveUserData['message']);
        }
        $response = $this->saveCustomer($request->merge(['user_id' => $saveUserData['data']->id]));
        if($response['state'] == 200){
            return redirect()->route('clientes.index')->with('success', 'Cliente registrado exitosamente.');
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
        $customer = Customer::find($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::where('id', $id)->with('getUser')->first();
        $documents = ParameterValue::where('parameter_id', 1)->get();
        return view('customers.edit', compact('customer', 'documents'));
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
        $response = $this->updateCustomer($request, $id);
        if($response['state'] == 200){
            return redirect()->route('clientes.index')->with('success', $response['message']);
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
        $response = $this->deleteCustomer($id);
        if($response['state'] == 200){
            return redirect()->route('clientes.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
