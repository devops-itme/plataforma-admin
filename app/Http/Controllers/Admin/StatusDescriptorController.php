<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Http\Controllers\Traits\StatusDescriptorTrait;
use App\Role;
use App\StatusDescriptor;
use App\StatusMatrix;
use Illuminate\Http\Request;
use Symfony\Component\Console\Descriptor\Descriptor;

class StatusDescriptorController extends Controller
{
    use RestActions, StatusDescriptorTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $statusDescriptor = StatusDescriptor::where('status_matrix_id', $id)->get();
        return $this->respond(200, $statusDescriptor, null, 'Descriptores del estado');
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
    public function store(Request $request, $id)
    {

        $statusDescriptor = $this->storeDescriptor($request, $id);
        return $statusDescriptor;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->deleteDescriptor($id);
        return $response;
    }
}
