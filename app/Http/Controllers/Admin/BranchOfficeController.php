<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BranchOffice;
use App\Http\Controllers\Traits\BranchOfficeTrait;
use App\Parameter;
use App\ParameterValue;
use App\User;
use App\UserBranch;
use App\UserDeparment;

class BranchOfficeController extends Controller
{
    use BranchOfficeTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $bankData = User::where('id', $user_id)->with('getCustomer')->first();
        $branchOffices = BranchOffice::where('user_id', $user_id)
            ->name(request()->name)
            ->description(request()->description)
            ->address(request()->address)
            ->email(request()->email)
            ->phone(request()->phone)
            ->default(request()->default)
            ->get();

        return view('branchOffices.index', compact('bankData', 'branchOffices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $documents = ParameterValue::where('parameter_id',1)->get();
        //method
        $payment_method_id = Parameter::where('name', 'payment_method')->first();
        $payment_method = ParameterValue::where('parameter_id', $payment_method_id->id)->get();
        //type
        $branch_office_type_id = Parameter::where('name', 'branch_office_type')->first();
        $branch_office_type = ParameterValue::where('parameter_id', $branch_office_type_id->id)->get();
        //use_mode
        $use_mode_id = Parameter::where('name', 'use_mode')->first();
        $use_mode = ParameterValue::where('parameter_id', $use_mode_id->id)->get();
        return view('branchOffices.create', compact('documents','user_id', 'payment_method', 'branch_office_type', 'use_mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        if($request->branch_office_payment_method == 24){
            $request->merge(['branch_office_usage_mode' => null]);
            $request->merge(['branch_office_plan' => null]);
        }
        if($request->branch_office_type == 'Seleccione'){
            $request->merge(['branch_office_type' => null]);
        }
        $response = $this->saveBranchOffice($request);

        if($response['state'] == 200){
            if($request->branch_office_department != ''){
                $saveBranchDept = $this->storeBranchDepartment($response['data']->id, $request->branch_office_department);
                if($saveBranchDept){
                    $userDept = UserDeparment::where('department_id', $saveBranchDept['data']->department_id)->first();
                    if($userDept){
                        $saveUserBranch = $this->storeUserBranch($userDept->user_id , $response['data']->id);
                        if($saveUserBranch['state'] != 200){
                            return json_encode([
                                'state' => 500,
                                'error' => $saveUserBranch['error']
                            ]);
                        }
                    }
                }

                if($saveBranchDept['state'] != 200){
                    return json_encode([
                        'state' => 500,
                        'error' => $saveBranchDept['message']
                    ]);
                }
            }
            if($response['data']->user_id){
                $saveUserBranch = $this->storeUserBranch($response['data']->user_id, $response['data']->id);
                if($saveUserBranch['state'] != 200){
                    return json_encode([
                        'state' => 500,
                        'error' => $saveUserBranch['error']
                    ]);
                }
            }
            return json_encode([
                'state' => 200,
                'data' => $response['data']
            ]);
        } else {
            return json_encode([
                'state' => 500,
                'error' => $response['error']
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($parent_id, $id)
    {
        $office = BranchOffice::where('id', $id)->with('getDepartment')->first();
        $documents = ParameterValue::where('parameter_id',1)->get();
        // return view('branchOffices.show', compact('office', 'documents'));
        return json_encode([
            'state' => '200',
            'data' => [$office, $documents]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($parent_id, $id)
    {
        $office = BranchOffice::where('id', $id)->first();
        $documents = ParameterValue::where('parameter_id',1)->get();
        //type
        $branch_office_type_id = Parameter::where('name', 'branch_office_types')->first();
        $branch_office_type = ParameterValue::where('parameter_id', $branch_office_type_id->id)->get();
        //method
        $payment_method_id = Parameter::where('name', 'payment_method')->first();
        $payment_method = ParameterValue::where('parameter_id', $payment_method_id->id)->get();
        return view('branchOffices.edit', compact('office', 'documents', 'branch_office_type', 'payment_method'));
    }

    public function allBranches()
    {
        $branches = BranchOffice::get();
        return json_encode([
            'state' => 200,
            'data' => $branches
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $parent_id, $id)
    {
        $response = $this->updateBranchOffice($request->merge(['office_id' => $id]));
        if($response['state'] == 200){
            if($request->branch_office_department != 'Seleccione'){
                $saveBranchDept = $this->storeBranchDepartment($response['data']->id, $request->branch_office_department);
                if($saveBranchDept){
                    $userDept = UserDeparment::where('department_id', $saveBranchDept['data']->department_id)->first();
                    if($userDept){
                        $saveUserBranch = $this->storeUserBranch($userDept->user_id, $response['data']->id);
                        if($saveUserBranch['state'] != 200){
                            return json_encode([
                                'state' => 500,
                                'error' => $saveUserBranch['error']
                            ]);
                        }
                    }
                }
                if($saveBranchDept['state'] != 200){
                    return json_encode([
                        'state' => 500,
                        'error' => $saveBranchDept['message']
                    ]);
                }
            }
            return json_encode([
                    'state' => 200,
                    'data' => $response['data'],
                    'message' => $response['message']
                ]);
            // return redirect()->route('branchOffices.index', $parent_id)->with('success', $response['message']);
        } else {
            // return redirect()->back()->with('danger', $response['message']);
            return json_encode([
                'state' => 500,
                'error' => $response['error']
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($parent_id, $id)
    {
        $response = $this->deleteBranchOffice($id);
        if($response['state'] == 200){
            return redirect()->back()->with('success', $response['message']);
            // return redirect()->route('branchOffices.index', $parent_id)->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['error']);
        }
    }

    public function unassigned_branch_offices()
    {
        if(request()->customer != "null"){
            $customer_id = request()->customer;

            $branches = BranchOffice::with('getBranchUser')->whereHas('getBranchUser', function ($query) use ($customer_id) {
                $query->where('user_id', $customer_id);
            })->with('getType', 'getZone')->get();
        } else {
            $assignedBranches = UserBranch::get('branch_office_id');
            $ids = [];
            foreach ($assignedBranches as $key) {
                array_push($ids, $key->branch_office_id);
            }
            $branches = BranchOffice::whereNotIn('id', $ids)->with('getType', 'getZone')->get();
        }
        return json_encode([
            'state' => 200,
            'data' => $branches
        ]);
    }
}
