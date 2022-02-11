<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BranchOffice;
use App\Http\Controllers\Traits\BranchOfficeTrait;
use App\Parameter;
use App\ParameterValue;
use App\User;

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
        $response = $this->saveBranchOffice($request->merge(['user_id' => $user_id]));
        if($response['state'] == 200){
            return redirect()->route('branchOffices.index', $user_id)->with('success', $response['message']);
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
    public function show($parent_id, $id)
    {
        $office = BranchOffice::where('id', $id)->first();
        $documents = ParameterValue::where('parameter_id',1)->get();
        return view('branchOffices.show', compact('office', 'documents'));
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
        return view('branchOffices.edit', compact('office', 'documents'));
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
            return redirect()->route('branchOffices.index', $parent_id)->with('success', $response['message']);
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
    public function destroy($parent_id, $id)
    {
        $response = $this->deleteBranchOffice($id);
        if($response['state'] == 200){
            return redirect()->route('branchOffices.index', $parent_id)->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
