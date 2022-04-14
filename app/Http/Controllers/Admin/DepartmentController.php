<?php

namespace App\Http\Controllers\Admin;

use App\BranchOffice;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DepartmentTrait;
use App\UserDepartment;
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

        return $this->respond(200, $departments, null, 'Lista de departamentos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            return $this->respond($response['state'], $response['data'], $response['error'],  $response['message']);
        } else {
            return $this->respond($response['state'], $response['data'], $response['error'],  $response['message']);

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
        // $department = $department['data'];
        return $this->respond($department['state'], $department['data'], $department['error'],  $department['message']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
            return $this->respond($response['state'], $response['data'], $response['error'],  $response['message']);
        } else {
            return $this->respond($response['state'], $response['data'], $response['error'],  $response['message']);
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
            return $this->respond($response['state'], $response['data'], $response['error'],  $response['message']);
        } else {
            return $this->respond($response['state'], $response['data'], $response['error'],  $response['message']);
        }
    }

    public function UnassignedDepts()
    {
        $assignedDepts = UserDepartment::get('department_id');
        $ids = [];
        foreach ($assignedDepts as $key) {
            array_push($ids, $key->department_id);
        }
        $unassignedDepts = Department::whereIn('id', $ids)->get();
        return json_encode([
            'state' => 200,
            'data' => $unassignedDepts
        ]);
    }
}
