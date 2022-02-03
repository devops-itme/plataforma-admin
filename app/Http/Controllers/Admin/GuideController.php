<?php

namespace App\Http\Controllers\Admin;

use App\Guide;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GuidanceDocsTrait;
use App\Http\Controllers\Traits\GuideTrait;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    use GuideTrait, GuidanceDocsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = Guide::get();
        return json_encode($guides);
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
        $response = $this->storeGuide($request);
        if($response['state'] == 200){
            if(!is_null($request->guides_doc)){
                $guidance_docs = $this->storeGuidanceDoc($request->merge(['guides_id' => $response['data']->id]));
                if($guidance_docs['state'] != 200){
                    return json_encode($response, $response['message']);
                }
            }
            return json_encode([
                'data' => $response['data'],
                'state' => $response['state'],
                'message' => 'Guia guardada exitosamente'
            ]);
        } else {
            return json_encode($response['error']);
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
        $guide = Guide::find($id);
        return json_encode($guide);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guide = Guide::find($id);
        return json_encode($guide);
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
        $response = $this->updateGuide($request->merge(['guide_id' => $id]));
        if($response['state'] == 200){
            return json_encode([
                'data' => $response['data'],
                'state' => $response['state'],
                'message' => 'Guia guardada exitosamente'
            ]);
        } else {
            return json_encode($response['message']);
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
            return json_encode([
                'state' => $response['state'],
                'message' => 'Guia eliminada'
            ]);
        } else {
            return json_encode($response['error']);
        }
    }
}
