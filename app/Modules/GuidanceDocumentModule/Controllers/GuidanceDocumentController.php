<?php

namespace App\Modules\GuidanceDocumentModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use Illuminate\Http\Request;

class GuidanceDocumentController extends Controller
{

    protected $GuidanceDocument;

    public function __construct()
    {
        $this->GuidanceDocument = new GuidanceDocument();
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->GuidanceDocument->saveGuidanceDoc($request);
        if($response['state'] == 200){
            return json_encode($response['data'], 'Guardado exitoso');
        } else {
            return json_encode($response['message'], 'Error');
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
        $response = $this->GuidanceDocument->updateGuidanceDoc($request->merge(['guidance_doc_id' => $id]));
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
        $response = $this->GuidanceDocument->deleteGuidanceDoc($id);
        if($response['state'] == 200){
            return json_encode($response['data'], 'Eliminación exitosa');
        } else {
            return json_encode($response['message'], 'Error');
        }
    }
}
