<?php

namespace App\Http\Controllers\Admin;

use App\BranchOffice;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DepartmentTrait;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use DepartmentTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->getDepartments();
        $departments = $departments['data'];

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branch_offices = null;
        $user_id = Request()->user_id;

        if (!is_null($user_id)) {
            $branch_offices = BranchOffice::where('user_id', $user_id)->get();
        }
        $branch_office_id = Request()->branch_office_id;

        return view('departments.create', compact('branch_offices', 'branch_office_id', 'user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->saveDepartment($request);
        if ($response['state'] == 200) {
            $exist_user_id = !is_null($request->user_id);
            $requestName = $exist_user_id ? 'user_id' : 'branch_office_id';
            $requestData = [$requestName =>  $exist_user_id ? $request->user_id : $request->branch_office_id];

            return redirect()->route('departments.index', $requestData)->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['error']);
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
        $department = $this->showDepartment($id);
        $department = $department['data'];
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = $this->showDepartment($id);
        $department = $department['data'];
        $user_id = Request()->user_id;
        $branch_offices = null;
        if (!is_null($user_id)) {
            $branch_offices = BranchOffice::where('user_id', $user_id)->get();
        }
        $branch_office_id = Request()->branch_office_id;
        return view('departments.edit', compact('department','branch_offices', 'branch_office_id', 'user_id'));
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
        $response = $this->updateDepartment($request, $id);

        if ($response['state'] == 200) {
            $exist_user_id = !is_null($request->user_id);
            $requestName = $exist_user_id ? 'user_id' : 'branch_office_id';
            $requestData = [$requestName =>  $exist_user_id ? $request->user_id : $request->branch_office_id];
            return redirect()->route('departments.index', $requestData)->with('success',  $response['message']);
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
        $response = $this->deleteDepartment($id);
        if ($response['state'] == 200) {
            return redirect()->route('departments.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
