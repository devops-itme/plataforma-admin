<?php

namespace App\Modules\GuideModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Http\Resources\GuideResource;
use App\Imports\GuidesImport;
use App\Modules\AddressModule\Address;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\GuideLogModule\GuideLog;
use App\Modules\GuideModule\Guide;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RouteModule\Route;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class GuideController extends Controller
{
    use GuideTrait;

    protected $path = 'GuideModule.views.html.guides.';
    protected $GuidanceDocument;
    public function __construct()
    {
        $this->GuidanceDocument = new GuidanceDocument();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = [];
        if (str_contains(request()->path, 'create')) {
            $guides = Guide::where('order_id', NULL)->with('getState')->get();
        } else if (str_contains(request()->path, 'edit')) {
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
        $request->merge([
            'same_day_delivery' => $request->same_day_delivery == 'on' ? 1 : 0,
            'sign' => $request->sign == 'on' ? 1 : 0,
            'take_photo' => $request->take_photo == 'on' ? 1 : 0,
            'return_last_destination' => $request->guide_return_last_destination,
        ]);

        $address = Address::find($request->guide_address);
        if (is_null($address)) {
            return redirect()->back()->with('danger', 'Debe seleccionar una dirección de destino');
        }
        $request->merge([
            'address_id' => $address->id,
            'address_name' => $address->name,
            'address_lat' => $address->lat,
            'address_lng' => $address->lng,
            'address_description' => $address->description
        ]);

        $response = $this->storeGuide($request);
        if ($response['state'] != 200) {
            return redirect()->back()->with('danger', $response['message']);
        }

        if (!is_null($request->guides_doc)) {
            $guidance_docs = $this->GuidanceDocument->saveGuidanceDoc($request->merge(['guide_id' => $response['data']->id]));
            if ($guidance_docs['state'] != 200) {
                return redirect()->back()->with('danger', $response['message']);
            }
        }

        return redirect()->back()->with('success', $response['message']);
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
        $user_id = $guide->getOrder->getUser->id;
        $addresses = Address::where('user_id', $user_id)->get();
        $guide_id = $guide->getOrder->id;
        return view($this->path . 'edit', compact('guide', 'addresses','guide_id'));
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
        $request->merge([
            'same_day_delivery' => $request->same_day_delivery == 'on' ? 1 : 0,
            'sign' => $request->sign == 'on' ? 1 : 0,
            'take_photo' => $request->take_photo == 'on' ? 1 : 0,
            'description' => $request->guide_description,
        ]);

        $address = Address::find($request->address_id);
        if (is_null($address)) {
            return redirect()->back()->with('danger', 'Debe seleccionar una dirección');
        }
        $request->merge([
            'address_name' => $address->name,
            'address_lat' => $address->lat,
            'address_lng' => $address->lng,
            'address_description' => $address->description
        ]);

        $response = $this->updateGuide($request->merge(['guide_id' => $id]));
        if ($response['state'] != 200) {
            return redirect()->back()->with('danger', $response['message']);
        }
        return redirect()->back()->with('success', $response['message']);
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
        if ($response['state'] == 200) {
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

            $state == 5 ? $state = [4, 5, 6] : ($state == 9 ?  $state = [8, 9, 10] : $state = [intval($state)]);
            // $guides = Guide::with('getOrder.getUser.getCustomer')->whereHas('getOrder', function ($query) {
            //     $query->whereHas('getUser')->where('order_type', 36);
            // })->whereIn('status_matrix_id', $state)
            //     ->with(['getRoute.getMessenger', 'getTransportType', 'getOrder.getOrderType', 'getBranchOffice.getDepartment.getDepartment', 'getStatusMatrix', 'getDocuments','getGuideLogs.getIssue'])
            //     ->get();

                $guide_pickup = [];
                $GuideLog_pickup = GuideLog::with(['getState',
                    'getGuide.getOrder.getUser.getCustomer',
                    'getGuide.getTransportType',
                    'getGuide.getOrder.getOrderType',
                    'getGuide.getBranchOffice.getDepartment.getDepartment'
                ])->whereHas('getState', function($query){
                    $query->whereHas('getScope', function($query){
                        $query->where('name', 'pickup');
                    });
                })->orderBy('created_at', 'ASC')->get();

                foreach ($GuideLog_pickup as $key => $item) {
                    array_push($guide_pickup, $item);
                }
                $guide_pickup_new = array_values(array_column($guide_pickup, null, "guide_id"));

                $guides_pickup_arr = collect($guide_pickup_new)->map(function($item) use ($GuideLog_pickup){
                    $data_guide_log = $GuideLog_pickup->where('guide_id', $item->getGuide->id)->first();
                    $data_guide_log2 = $GuideLog_pickup->where('guide_id', $item->getGuide->id)->last();
                    $item->getGuide->status_matrix_id = $item->status_matrix_id;
                    if($data_guide_log){
                        $package_picture = ParameterValue::where('name', 'package_picture')->first();
                        $documents = GuidanceDocument::where('guide_id', $item->getGuide->id)->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->orWhere(function($query) use($item, $package_picture){
                            $query->where('guide_id', $item->getGuide->id)
                            ->where('type', $package_picture->id);
                        })->get();
                        $route = Route::where('guide_id', $item->getGuide->id)->with('getMessenger.getMessenger')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->first();
                        $Issue = GuideLog::where('guide_id', $item->getGuide->id)->where('issue_id','<>',null)->with('getIssue')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->first();
                        $status_matrix = StatusMatrix::find($item->status_matrix_id);
                        $item->getGuide->get_documents = $documents;
                        $item->getGuide->get_route = $route;
                        $item->getGuide->get_status_matrix = $status_matrix;
                        if(isset($Issue)){
                            $item->getGuide->get_issue = $Issue;
                            $item->getGuide->novelty =  json_decode($Issue->url_document)->novelty ?? '';
                            $item->getGuide->recipient_name =  json_decode($Issue->url_document)->recipient_name ?? '';
                            $item->getGuide->additional_phone =  json_decode($Issue->url_document)->additional_phone ?? '';
                            $item->getGuide->additional_email =  json_decode($Issue->url_document)->additional_email ?? '';
                            $item->getGuide->additional_address =  json_decode($Issue->url_document)->additional_address ?? '';
                        }
                    }

                    return $item->getGuide;
                });

                $guide_delivery = [];
                $GuideLog_delivery = GuideLog::with(['getState',
                    'getGuide.getOrder.getUser.getCustomer',
                    'getGuide.getTransportType',
                    'getGuide.getOrder.getOrderType',
                    'getGuide.getBranchOffice.getDepartment.getDepartment'
                ])->whereHas('getState', function($query){
                    $query->whereHas('getScope', function($query){
                        $query->where('name', 'delivery');
                    });
                })->orderBy('created_at', 'ASC')->get();

                foreach ($GuideLog_delivery as $key => $item) {
                    array_push($guide_delivery, $item);
                }
                $guide_delivery_new = array_values(array_column($guide_delivery, null, "guide_id"));

                $guides_delivery_arr = collect($guide_delivery_new)->map(function($item) use ($GuideLog_delivery){
                    $data_guide_log = $GuideLog_delivery->where('guide_id', $item->getGuide->id)->first();
                    $data_guide_log2 = $GuideLog_delivery->where('guide_id', $item->getGuide->id)->last();
                    $item->getGuide->status_matrix_id = $item->status_matrix_id;
                    if($data_guide_log){
                        $documents = GuidanceDocument::where('guide_id', $item->getGuide->id)->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->get();
                        $route = Route::where('guide_id', $item->getGuide->id)->with('getMessenger.getMessenger')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->first();
                        $Issue = GuideLog::where('guide_id', $item->getGuide->id)->where('issue_id','<>',null)->with('getIssue')->orderBy('created_at', 'DESC')->whereBetween('created_at', [date($data_guide_log->created_at), date($data_guide_log2->created_at)])->first();
                        $status_matrix = StatusMatrix::find($item->status_matrix_id);
                        $item->getGuide->get_documents = $documents;
                        $item->getGuide->get_route = $route;
                        $item->getGuide->get_status_matrix = $status_matrix;
                        if(isset($Issue)){
                            $item->getGuide->get_issue = $Issue;
                            $item->getGuide->novelty =  json_decode($Issue->url_document)->novelty ?? '';
                            $item->getGuide->recipient_name =  json_decode($Issue->url_document)->recipient_name ?? '';
                            $item->getGuide->additional_phone =  json_decode($Issue->url_document)->additional_phone ?? '';
                            $item->getGuide->additional_email =  json_decode($Issue->url_document)->additional_email ?? '';
                            $item->getGuide->additional_address =  json_decode($Issue->url_document)->additional_address ?? '';
                        }
                    }


                    return $item->getGuide;
                });

                $new_guides = $guides_delivery_arr->merge($guides_pickup_arr);
                $guides = $new_guides->whereIn('status_matrix_id', $state);

                $guide_arr = [];
                foreach ($guides as $key => $item) {
                    array_push($guide_arr, $item);
                }


            return $this->respond(200, $guide_arr, null, 'Lista de guías packing');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function porDespacharPackaging(Request $request, $id)
    {
        try {
            $type = $request->type;

            $guides = Guide::where('order_id', $id)->get();
            foreach ($guides as $guide) {
                $guide->update([
                    'status_matrix_id' => $type
                ]);
            }
            $order = Order::where('id', $id)->first();
            $order->update([
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
        $order_id = $request->order_id;

        if ($request->hasFile('file')) {
            $file_import = $request->file('file');
            Excel::import(new GuidesImport($order_id), $file_import);
            return $this->respond(200,  [], null, 'Importación de guías completada');
        }
        return $this->respond(500,  [], '', 'Error al importar archivo');
    }

    public function updatePackingGuide(Request $request)
    {
        try {
            $guide = Guide::findOrFail($request->id);
            $guide->update([
                'additional_address' => $request->additional_address,
                'additional_email' => $request->additional_email,
                'additional_phone' => $request->additional_phone,
                'address_name' => $request->address,
                'app_status' => $request->app_status,
                'concept' => $request->concept,
                'contact' => $request->contact,
                'email_contact' => $request->contact_email,
                'phone_contact' => $request->contact_phone,
                'customer_document_type' => $request->document_type,
                'transport_type' => $request->transport_type,
                'value' => $request->value,
                'value_corp' => $request->corp_value,
                'novelty' => $request->novelty
            ]);

            $order_id = $guide->order_id;
            $order = Order::findOrFail($order_id);

            $order->update([
             'schedule_date' => $request->schedule_date,
         ]);

            return $this->respond(200,$guide,$order,'Guía actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar guía');
        }
    }

    public function validateGuide(Request $request)
    {
        try {
            $Address = new Address();
            $addressResponse = $Address->showAddress($request->address_id);
            $address = $addressResponse['data'];
            if ($addressResponse['state'] != 200) {
                return $this->respond(500,  null, $addressResponse['error'], 'La dirección es obligatoria');
            }
            $request->merge([
                'address_name' => $address->name,
                'address_lat' => $address->lat,
                'address_lng' => $address->lng,
                'address_description' => $address->description,
            ]);

            $Guide = new Guide();

            $validator = $Guide->validateGuide($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            return $this->respond(200, $request->all(), null, 'Guía validada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al validar guía');
        }
    }

}
