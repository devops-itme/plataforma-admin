<?php

namespace App\Modules\GuideModule\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\GuidesImport;
use App\Modules\AddressModule\Address;
use App\Modules\GuidanceDocumentModule\Controllers\GuidanceDocsTrait;
use App\Modules\GuideModule\Guide;
use App\Modules\OrderModule\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


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
            $guides = Guide::where('order_id', NULL)->with('getState')->get();
        } else if(str_contains(request()->path, 'edit')){
            $order_id = request()->order;
            $guides = Guide::with('getOrder')->whereHas('getOrder', function ($query) use ($order_id) {
                $query->where('order_number', $order_id);
            })->orWhere('order_id', NULL)->with('getState')->get();
        } else {
            $order_id = request()->order;
            $guides = Guide::with('getOrder')->whereHas('getOrder', function ($query) use ($order_id) {
                $query->where('order_number', $order_id);
            })->with('getState')->get();
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
        if($request->zone == 'Seleccione'){$request->merge(['zone' => NULL]);}
        $request->merge(['return_last_destination' => $request->return_last_destination == 'on' ? 1 : 0]);
        if($request->address_name){
            $address = Address::find($request->address_name);
            if(!is_null($address)){
                $request->merge([
                    'address_name' => $address->name,
                    'address_lat' => $address->lat,
                    'address_lng' => $address->lng,
                    'address_description' => $address->description
                ]);
            }
        }
        // if($request->customer_address == 'Seleccione'){$request->merge(['customer_address' => NULL]);}
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
        if($request->zone == 'Seleccione'){$request->merge(['zone' => NULL]);}
        if(!($request->state)){
            $request->merge(['state' => 31]);
        }
        $request->merge(['return_last_destination' => $request->return_last_destination == 'on' ? 1 : 0]);

        if($request->address_name){
            $address = Address::find($request->address_name);
            if(!is_null($address)){
                $request->merge([
                    'address_name' => $address->name,
                    'address_lat' => $address->lat,
                    'address_lng' => $address->lng,
                    'address_description' => $address->description
                ]);
            }
        }
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

    public function guidesForDeliveryPacking($state)
    {

        try {

            $state == 5? $state = [3,4,5,6] : ( $state == 9?  $state = [7,8,9,10] : $state =[intval($state)]);
            $guides = Guide::with('getOrder.getUser.getCustomer')->whereHas('getOrder', function ($query)  {
                $query->where('order_type', 36);
            })->whereIn('status_matrix_id', $state)
            ->with(['getRoute.getMessenger', 'getTransportType', 'getOrder.getOrderType', 'getBranchOffice.getDepartment.getDepartment'])
            ->get();

            return $this->respond(200, $guides, null, 'Lista de guiás packing');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function porDespacharPackaging(Request $request, $id)
    {
        try {
            $type = $request->type;
            // $order_type = Order::with('getGuides')->whereHas('getGuides', function ($query) use ($id, $type) {
            //     $query->where('order_id', $id)->update([
            //         'status_matrix_id' => $type
            //     ]);
            // })->update([
            //     'status_matrix_id' => $type
            // ]);
            $guides = Guide::where('order_id', $id)->update([
                'status_matrix_id' => $type
            ]);
            $order = Order::where('id', $id)->update([
                'status_matrix_id' => $type
            ]);
            return $this->respond(200, [], null, 'Estado actualizado');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function importGuide(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'nullable',
            'file' => 'required | mimes:xlsx',
            
        ]);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
     
        if($request->hasFile('file')){
           $file_import = $request->file('file');
           Excel::import(new GuidesImport, $file_import);
        return $this->respond(200,  [], null, 'Importación de guías completada');
        }
        return $this->respond(500,  [], '', 'Error al importar archivo');
       

    }

}
