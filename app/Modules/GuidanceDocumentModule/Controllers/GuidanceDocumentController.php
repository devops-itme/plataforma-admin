<?php

namespace App\Modules\GuidanceDocumentModule\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuidanceDocumentController extends Controller
{
    use GuidanceDocsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $response = $this->storeGuidanceDoc($request);
        if($response['state'] == 200){
            return json_encode($response['data'], 'Guardado exitoso');
        } else {
            return json_encode($response['message'], 'Error');
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
        $response = $this->updateGuidanceDoc($request->merge(['guidance_doc_id' => $id]));
        if($response['state'] == 200){
            return json_encode($response['data'], 'Actualización exitosa');
        } else {
            return json_encode($response['message'], 'Error');
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
        $response = $this->deleteGuide($id);
        if($response['state'] == 200){
            return json_encode($response['data'], 'Eliminación exitosa');
        } else {
            return json_encode($response['message'], 'Error');
        }
    }
}
