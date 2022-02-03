<?php

namespace App\Http\Controllers\Admin;

use App\Chat;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ChatTrait;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use ChatTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = $this->getChats();
        $chats = $chats['data'];
        return $this->respond(200, $chats, null, 'Lista de chats');
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
        $response = $this->saveChat($request);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = $this->showChat($id);
        $address = $address['data'];
        return $this->respond(200, $address, null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
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
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = $this->updateChat($request, $id);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->deleteChat($id);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, $response['message']);
        } else {
            return $this->respond(500, null, $response['error'], $response['message']);
        }
    }
}
