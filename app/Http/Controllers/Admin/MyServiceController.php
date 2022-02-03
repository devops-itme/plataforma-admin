<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MyServiceTrait;
use Illuminate\Http\Request;

class MyServiceController extends Controller
{
    use MyServiceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myServices = $this->getMyServices();
        $myServices = $myServices['data'];
        return $this->respond(200, $myServices, null, 'Lista de servicios');
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
        $response = $this->saveMyService($request);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
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
        $myService = $this->showMyService($id);
        $myService = $myService['data'];
        return $this->respond(200, $myService, null);
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
        $response = $this->updateMyService($request, $id);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
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
        $response = $this->deleteMyService($id);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }
}
