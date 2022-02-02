<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ReportTrait;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ReportTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = $this->getReports();
        $reports = $reports['data'];
        return $this->respond(200, $reports, null, 'Lista de direcciones');
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
        $response = $this->saveReport($request);
        if($response['state'] == 200){
            return $this->respond(200, $response, null, $response['message']);
        } else {
            return $this->respond(500, null, $response, $response['message']);
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
        $report = $this->showReport($id);
        $report = $report['data'];
        return $this->respond(200, $report, null);
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
        $response = $this->updateReport($request, $id);
        if ($response['state'] == 200) {
            return $this->respond(200, $response, null, $response['message']);
        } else {
            return $this->respond(500, null, $response, $response['message']);
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
        $response = $this->deleteReport($id);
        if($response['state'] == 200){
            return $this->respond(200, $response, null, $response['message']);
        } else {
            return $this->respond(500, null, $response, $response['message']);
        }
    }
}
