<?php

namespace App\Http\Controllers\Admin;

use App\BranchOffice;
use App\Customer;
use App\Department;
use App\Http\Controllers\Controller;
use App\ParameterValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use App\Http\Controllers\Traits\CustomerTrait;
use App\Http\Controllers\Traits\BranchOfficeTrait;
use App\Http\Controllers\Traits\RestActions;
use App\Parameter;
use App\User;
use App\UserBranch;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use CustomerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::name(request()->name)
            ->document(request()->document)
            ->email(request()->email)
            ->phone(request()->phone)
            ->zone(request()->zone)
            ->state(request()->state)
            ->latest()
            ->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'document_type');
        })->get();
        //period
        $payment_period = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_period');
        })->get();
        //method
        $payment_method = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_method');
        })->get();
        //type
        $branch_office_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'branch_office_types');
        })->get();
        //use_mode
        $use_mode = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'use_mode');
        })->get();
        $plans = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'plans');
        })->get();
        return view('customers.create', compact('documents', 'payment_period', 'payment_method', 'branch_office_type', 'use_mode', 'plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(is_null($request->name) && is_null($request->business_name)){
            return redirect()->back()->with('danger', 'Error. La entidad debe tener nombre.');
        }
        $saveUserData = $this->saveUser($request->merge(['state' => 1, 'role' => 4]));
        if($saveUserData['state'] != 200){
            // return redirect()->back()->with('danger', $saveUserData['message']);
            return json_encode([
                'state' => 500,
                'message' => $saveUserData['message']
            ]);
        }
        if(!is_null($request->branchCheck)){
            $request->branchCheck = explode(',', $request->branchCheck);
            $assignBranches = $this->storeUserBranch($saveUserData['data']->id, $request->branchCheck);
            if($assignBranches['state'] != 200){
                // return redirect()->back()->with('danger', $assignBranches['message']);
                return json_encode([
                    'state' => 500,
                    'message' => $assignBranches['message']
                ]);
            }
        }
        if(!is_null($request->departments)){
            $request->departments = explode(',', $request->departments);
            $assignDepartment = $this->storeUserDepartment($saveUserData['data']->id, $request->departments);
            if($assignDepartment['state'] != 200){
                // return redirect()->back()->with('danger', $assignDepartment['message']);
                return json_encode([
                    'state' => 500,
                    'message' => $assignDepartment['message']
                ]);
            }
        }
        // if(!is_null($request->branch_office_name)){
        //     $saveBranchOfficeData = $this->saveBranchOffice($request->merge(['user_id' => $saveUserData['data']->id]));
        //     if($saveBranchOfficeData['state'] != 200){
        //         return redirect()->back()->with('danger', $saveBranchOfficeData['error']);
        //     }
        // }
        $response = $this->saveCustomer($request->merge(['user_id' => $saveUserData['data']->id]));
        if($response['state'] == 200){
            return json_encode([
                'state' => 200,
                'message' => $response['message']
            ]);
        } else {
            return json_encode([
                'state' => 500,
                'message' => $response['message']
            ]);
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
        $customer = Customer::with('getUser')->find($id);
        $documents = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'document_type');
        })->get();
        //period
        $payment_period = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_period');
        })->get();
        //method
        $payment_method = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_method');
        })->get();
        //type
        $branch_office_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'branch_office_types');
        })->get();
        //use_mode
        $use_mode = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'use_mode');
        })->get();
        $plans = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'plans');
        })->get();
        return view('customers.show', compact('customer', 'documents', 'payment_method', 'payment_period', 'branch_office_type', 'use_mode', 'plans'));
    }

    public function customerData($id)
    {
        $branches = null;
        $departments = null;
        $customer = User::with(['getCustomer', 'getDocumentType'])->find($id);
        $branches = BranchOffice::with('getBranchUser')->whereHas('getBranchUser', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        $departments = Department::with('getDepartmentUser')->whereHas('getDepartmentUser', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        return json_encode([
            'state' => 200,
            'data' => [$customer, $branches, $departments]
        ]);
    }

    public function search_customer(Request $request)
    {
        $data = [];
        $type = 1;
        if(!is_null($request->value)){
            if(is_numeric($request->value)){
                $data = User::where('document_number', 'like', '%'.$request->value.'%')->where('role', 4)->with('getCustomer')->get();
                if(count($data) > 0){$type = 1;}
            } else {
                $data = Customer::where('tradename', 'like', '%'.$request->value.'%')->with('getUser')->get();
                if(count($data) == 0){
                    $data = User::where(DB::raw('concat(name," ",last_name)'), 'like', '%'.$request->value.'%')->where('role', 4)->with('getCustomer')->get();
                    if(count($data) > 0){$type = 1;}
                } else {$type = 2;}
            }
        }
        return json_encode([
            'state' => 200,
            'data' => $data,
            'type' => $type
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::with('getUSer')->find($id);
        $documents = ParameterValue::where('parameter_id', 1)->get();
        //period
        $payment_period = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_period');
        })->get();
        //method
        $payment_method = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'payment_method');
        })->get();
        //type
        $branch_office_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'branch_office_types');
        })->get();
        //use_mode
        $use_mode = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'use_mode');
        })->get();
        $plans = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'plans');
        })->get();
        return view('customers.edit', compact('customer','documents', 'payment_period', 'payment_method', 'branch_office_type', 'use_mode', 'plans'));
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
            return redirect()->route('customers.index')->with('success', $response['message']);
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
            return redirect()->route('customers.index')->with('success', $response['message']);
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
        try {
            $users = User::where('parent_id', $parent_id)->get();
            return json_encode([
                'state' => 200,
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'state' => 500,
                'message' => 'Ha ocurrido un error.',
                'error' => $e->getMessage()
            ]);
        }

    }

    public function UserBankCreate($parent_id = null)
    {
        return view('bankUsers.create', compact('parent_id'));
    }

    public function UserBankStore(Request $request, $parent_id = null)
    {
        if(is_null($request->password) && is_null($request->password_confirmation)){
            $request->merge(['password' => 'Admin1234', 'password_confirmation' => 'Admin1234']);
        }
        $response = $this->saveUser($request->merge(['parent_id' => $parent_id ? $parent_id : null, 'role' => 4, 'state' => 1]));
        if($response['state'] == 200){
            // return redirect()->route('bankUsers.index', $parent_id)->with('success', 'Usuario registrado exitosamente');
            return json_encode([
                'state' => 200,
                'message' => "Usuario creado exitosamente"
            ]);
        } else {
            // return redirect()->back()->with('danger', $response['message']);
            return json_encode([
                'state' => 500,
                'message' => "Error al crear usuario",
                'error' => $response['message']
            ]);
        }
    }

    public function UserBankShow($parent_id, $id)
    {
        $user = User::where('id', $id)->with('getParent.getCustomer')->first();
        return view('bankUsers.show', compact('user'));
    }

    public function UserBankEdit($parent_id, $id)
    {
        // $user = User::where('id', $id)->first();
        try {
            $user = User::find($id);
            return json_encode([
                'state' => 200,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'state' => 500,
                'message' => 'Ha ocurrido un error.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function UserBankUpdate($parent_id, $id)
    {
        $response = $this->updateUser(request()->merge(['user_id' => $id]));
        if($response['state'] == 200){
            // return redirect()->route('bankUsers.index', $parent_id)->with('success', 'Usuario actualizado exitosamente');
            return json_encode([
                'state' => 200,
                'message' => $response['message']
            ]);
        } else {
            // return redirect()->back()->with('danger', $response['message']);
            return json_encode([
                'state' => 500,
                'message' => $response['message'],
                'error' => $response['message']
            ]);
        }
    }

    public function UserBankDestroy($parent_id, $id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('bankUsers.index', $parent_id)->with('success', 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Error al eliminar usuario '.$e->getMessage());
        }
    }

    public function getBranchOffices($id)
    {
        $branchOffices = BranchOffice::where('user_id', $id)->get();
        if(is_null($branchOffices)){
            return "500";
        }
        return $branchOffices;
    }
}
