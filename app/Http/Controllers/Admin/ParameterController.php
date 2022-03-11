<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ParametersTrait;
use App\Parameter;
use App\ParameterValue;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    use ParametersTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Parameter::get();
        return view('parameters.index', compact('parameters'));
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
        $response = $this->storeParameter($request);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameters = ParameterValue::where('parameter_id', $id)->get();
        if(is_null($parameters)){
            return json_encode([
                'state' => 500,
                'message' => 'No se encontró el parametro'
            ]);
        }
        return json_encode([
            'state' => 200,
            'data' => $parameters
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameter = ParameterValue::find($id);
        if(is_null($parameter)){
            return json_encode([
                'state' => 500,
                'message' => 'No se encontró el parametro'
            ]);
        }
        return json_encode([
            'state' => 200,
            'data' => $parameter
        ]);
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
        if($request->state == 'on'){$request->merge(['state' => '1']);}
        else{$request->merge(['state' => 0]);}
        $response = $this->updateParameter($id, $request);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->deleteParameter($id);
        if($response['state'] == 200){
            return redirect()->route('parameters.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
    }
}
