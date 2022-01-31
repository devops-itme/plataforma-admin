<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\ParameterValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use App\Http\Controllers\Traits\CustomerTrait;
use App\User;

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
        $customers = Customer::latest()->get();
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
        if(!is_null($request->business_name) || !is_null($request->tradename)){
            if(!is_null($request->business_name) && !is_null($request->tradename)){
                $request->merge(['role' => 4]);
            } else {
                return redirect()->back()->withInput()->with('danger', '¡Error. Los usuarios tipo banco deben tener el nombre comercial y el nombre de la empresa!');
            }
        } else {
            $request->merge(['role' => 5]);
        }
        $saveUserData = $this->saveUser($request->merge(['state' => 1]));
        if($saveUserData['state'] != 200){
            return redirect()->back()->withInput()->with('danger', $saveUserData['message']);
        }
        $response = $this->saveCustomer($request->merge(['user_id' => $saveUserData['data']->id]));
        if($response['state'] == 200){
            return redirect()->route('clientes.index')->with('success', 'Cliente registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
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

    //BANKS

    public function BankIndex()
    {
        $banks = User::where('role', 4)->where('parent_id', NULL)->with('getCustomer')->get();
        return view('banks.index', compact('banks'));
    }

    //USER BANKS

    public function UserBankIndex($parent_id)
    {
        $bankData = User::find($parent_id);
        $users = User::where('parent_id', $parent_id)->get();
        return view('userBanks.index', compact('users', 'bankData'));
    }

    public function UserBankCreate($parent_id = null)
    {
        return view('userBanks.create', compact('parent_id'));
    }

    public function UserBankStore(Request $request, $parent_id = null)
    {
        if(is_null($request->password) && is_null($request->password_confirmation)){
            $request->merge(['password' => 'Admin1234', 'password_confirmation' => 'Admin1234']);
        }
        $response = $this->saveUser($request->merge(['parent_id' => $parent_id ? $parent_id : null, 'role' => 4, 'state' => 1]));
        if($response['state'] == 200){
            return redirect()->route('userBanks.index', $parent_id)->with('success', 'Usuario registrado exitosamente');
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }

    public function UserBankShow($parent_id, $id)
    {
        $user = User::where('id', $id)->with('getParent.getCustomer')->first();
        return view('userBanks.show', compact('user'));
    }

    public function UserBankEdit($parent_id, $id)
    {
        $user = User::where('id', $id)->first();
        return view('userBanks.edit', compact('user'));
    }

    public function UserBankUpdate($parent_id, $id)
    {
        $response = $this->updateUser(request()->merge(['user_id' => $id]));
        if($response['state'] == 200){
            return redirect()->route('userBanks.index', $parent_id)->with('success', 'Usuario actualizado exitosamente');
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }

    public function UserBankDestroy($parent_id, $id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('userBanks.index', $parent_id)->with('success', 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Error al eliminar usuario '.$e->getMessage());
        }
    }
}
