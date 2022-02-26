<?php

namespace App\Http\Controllers\Admin;

use App\Guide;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GuidanceDocsTrait;
use App\Http\Controllers\Traits\GuideTrait;
use App\Order;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    use GuidanceDocsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = [];
        if(str_contains(request()->path, 'create')){
            $guides = Guide::where('order_id', NULL)->get();
        } else if(str_contains(request()->path, 'edit')){
            $order_id = request()->order;
            $guides = Guide::with('getOrder')->whereHas('getOrder', function ($query) use ($order_id) {
                $query->where('order_number', $order_id);
            })->orWhere('order_id', NULL)->get();
        } else {
            $order_id = request()->order;
            $guides = Guide::with('getOrder')->whereHas('getOrder', function ($query) use ($order_id) {
                $query->where('order_number', $order_id);
            })->get();
        }
        return json_encode([
            'state' => 200,
            'data' => $guides
        ]);
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
        if($request->same_day_delivery == 'on'){$request->merge(['same_day_delivery' => 1]);}
        else{$request->merge(['same_day_delivery' => 0]);}
        if($request->sign == 'on'){$request->merge(['sign' => 1]);}
        else{$request->merge(['sign' => 0]);}
        if($request->take_photo == 'on'){$request->merge(['take_photo' => 1]);}
        else{$request->merge(['take_photo' => 0]);}

        if($request->address){
            $request->merge([
                'address_name' => $request->addres,
                'address_lat' => $request->lat,
                'address_lng' => $request->lng
            ]);
        }
        if($request->customer_address == 'Seleccione'){$request->merge(['customer_address' => NULL]);}
        $request->merge(['state' => 31]);
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
            return json_encode([
                'state' => 500,
                'error' => $response['error']
            ]);
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
        $guide = Guide::with('getOrder')->find($id);
        return json_encode([
            'state' => 200,
            'data' => $guide
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
        if(!($request->state)){
            $request->merge(['state' => 1]);
        }
        if($request->customer_address == 'Seleccione'){$request->merge(['customer_address' => NULL]);}
        $response = $this->updateGuide($request->merge(['guide_id' => $id]));
        if($response['state'] == 200){
            return json_encode([
                'data' => $response['data'],
                'state' => $response['state'],
                'message' => $response['message']
            ]);
        } else {
            return json_encode([
                'state' => 500,
                'message' => $response['error']
            ]);
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
