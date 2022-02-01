<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BranchOffice;
use App\Http\Controllers\Traits\BranchOfficeTrait;
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
        $branchOffices = BranchOffice::where('user_id', $user_id)->get();

        return view('branchOffices.index', compact('bankData', 'branchOffices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
