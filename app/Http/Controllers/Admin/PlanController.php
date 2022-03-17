<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PlansTrait;
use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use PlansTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::get();
        return view('plans.index', compact('plans'));
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
        $request->merge(['state' => 1]);
        $response = $this->storePlans($request);
        if($response['state'] == 200){
            return redirect()->route('plans.index')->with('success', $response['message']);
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
        $plan = Plan::find($id);
        if(!is_null($plan)){
            return $this->respond(200, $plan, '', 'Plan encontrado');
        } else {
            return $this->respond(500, [], 'plan not found', 'No se encontró el plan');
        }
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
        $request->merge(['state' => 1]);
        $response = $this->updatePlans($id, $request);
        if($response['state'] == 200){
            return redirect()->route('plans.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
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
        $response = $this->deletePlan($id);
        if($response['state'] == 200){
            return redirect()->route('planes')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
    }
}
