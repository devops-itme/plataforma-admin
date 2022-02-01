<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DepartmentTrait;
use App\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use DepartmentTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $departments = $this->getDepartments($id);
        $departments = $departments['data'];
        $user_id = User::find($id);
        $user_id = $user_id->id;
        return view('departments.index', compact('departments', 'user_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('departments.create',['user_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $response = $this->saveDepartment($request, $id);
        if($response['state'] == 200){
            return redirect()->route('department.index', $id)->with('success', $response['message']);
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
        return view('departments.edit', compact('department'));
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
        $user_id = $response['data']->user_id;
        if ($response['state'] == 200) {
            return redirect()->route('department.index', $user_id )->with('success',  $response['message']);
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
        if($response['state'] == 200){
            return redirect()->route('department.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
