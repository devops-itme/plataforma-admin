<?php

namespace App\Modules\MessengerModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\MessengerModule\Controllers\MessengerTrait;
use App\Modules\MessengerModule\Messenger;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    use MessengerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $path = 'MessengerModule.views.html.';

    public function index()
    {
        $messengers = $this->getMessengers();
        $messengers = $messengers['data'];
        return view($this->path . 'index', ['messengers' => $messengers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contract_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'contract_type');
        })->get();
        $document_type = ParameterValue::where('parameter_id', 1)->get();
        return view($this->path . 'create', compact('document_type', 'contract_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $messenger = $this->saveMessenger($request);
        if ($messenger['state'] == 200) {
            return redirect()->route('messengers.index')->with('success', 'Mensajero registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('danger', $messenger['message']);
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
        $messenger = $this->showMessenger($id);
        $messenger = $messenger['data'];

        return view($this->path.'show', compact('messenger'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $messenger = $this->showMessenger($id);
        $messenger = $messenger['data'];
        $document_type = ParameterValue::where('parameter_id', 1)->get();
        $contract_type = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'contract_type');
        })->get();
        return view($this->path . 'edit', compact('messenger', 'document_type', 'contract_type'));
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
        $messenger = $this->updateMessenger($request, $id);
        if ($messenger['state'] == 200) {
            return redirect()->route('messengers.index')->with('success',  $messenger['message']);
        } else {
            return redirect()->back()->with('danger', $messenger['message']);
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
        $response = $this->deleteMessenger($id);
        if ($response['state'] == 200) {
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(200, $response['data'], null, $response['message']);
        }
    }

    public function messengersForDelivery()
    {
        try {
            $messengers = Messenger::with(['user'])->get();
            return $this->respond(200, $messengers);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function download($id)
    {

       $messe = Messenger::find($id);
       $PathToFile = storage_path("app/document_file/".$messe->contract);
       return response()->download($PathToFile, 'contrato-mensajero.pdf');
    }
}
