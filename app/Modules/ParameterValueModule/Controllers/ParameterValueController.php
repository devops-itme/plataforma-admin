<?php

namespace App\Modules\ParameterValueModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Http\Request;

class ParameterValueController extends Controller
{
    use ParameterValueTrait;
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameters = ParameterValue::where('parameter_id', $id)->get();
        if (is_null($parameters)) {
            return json_encode([
                'state' => 500,
                'message' => 'No se encontró el parámetro'
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
        if (is_null($parameter)) {
            return json_encode([
                'state' => 500,
                'message' => 'No se encontró el parámetro'
            ]);
        }
        return json_encode([
            'state' => 200,
            'data' => $parameter
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->storeParameterValue($request);
        return $response;
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
        if ($request->state == 'on') {
            $request->merge(['state' => '1']);
        } else {
            $request->merge(['state' => 0]);
        }
        $response = $this->updateParameterValue($id, $request);
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
        $response = $this->deleteParameterValue($id);
        if ($response['state'] == 200) {
            return redirect()->route('parameter_value.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
    }
}
