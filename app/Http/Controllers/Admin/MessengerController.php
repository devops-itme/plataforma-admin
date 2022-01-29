<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MessengerTrait;
use App\Http\Requests\MessengerRequest;
use App\ParameterValue;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    use MessengerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messengers = $this->getMessengers();
        $messengers = $messengers['data'];
        // return $messengers;
        return view('messengers.index', ['messengers' => $messengers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document_type = ParameterValue::where('parameter_id', 1)->get();
        return view('messengers.create', compact('document_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->merge(['role' => 3, 'state' => 1]);
        $user = $this->saveUser($request);
        if($user['state'] != 200){
            return redirect()->back()->withInput()->with('danger', $user['message']);
        }
        $user = $user['data'];
        $messenger = $this->saveMessenger($request, $user->id);

        if($messenger['state'] == 200){
            return redirect()->route('messenger.index')->with('success', 'Mensajero registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('danger', $messenger['error']);
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
        $document_type = ParameterValue::where('parameter_id', 1)->get();
        return view('messengers.show', compact('messenger', 'document_type' ));
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
        return view('messengers.edit', compact('messenger', 'document_type' ));
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
            return redirect()->route('messenger.index')->with('success', $messenger['message']);
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
        if($response['state'] == 200){
            return redirect()->route('messenger.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
