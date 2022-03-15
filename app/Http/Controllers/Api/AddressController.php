<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AddressTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    use AddressTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id ?? Auth::user()->id;
        try {
            $addresses = Address::where('user_id', $user_id)->get();
            return $this->respond(200, $addresses, null, 'Direcciones de usuario');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
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
        // $user_id = $request->user_id ?? Auth::user()->id;
        // try {
        //     $addresses = Address::create(['user_id' => $user_id,
        //         'name' => $request->name,
        //         'lat' => $request->lat,
        //         'lng' => $request->lng,
        //         'description' => $request->description
        //     ]);
        //     return $this->respond(200, $addresses, null, 'Se ha creado una nueva dirección');
        // } catch (\Throwable $e) {
        //     return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        // }
        $response = $this->saveAddress($request);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, 'Se ha creado una nueva dirección');
        } else {
            return $this->respond($response['state'], null, null, 'Error del servidor');
        }
        // return json_encode([
        //     'state' => 200,
        //     'data' => $response['data'],
        //     'message' => $response['message']
        // ]);
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
        // try {
        //     $addresses = Address::findOrFail($id);
        //     $addresses->update($request->all());
        //     return $this->respond(200, $addresses, null, 'Se ha editado correctamente');
        // } catch (\Throwable $e) {
        //     return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        // }

        $response = $this->updateAddress($request, $id);
        if($response['state'] == 200){
            return $this->respond(200, $response['data'], null, 'Se ha editado correctamente');
        } else {
            return $this->respond($response['state'], null, null, 'Error del servidor');
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
        try {
            $addresses = Address::find($id)->delete();
            return $this->respond(204, $addresses, null, 'Se ha eliminado correctamente');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
