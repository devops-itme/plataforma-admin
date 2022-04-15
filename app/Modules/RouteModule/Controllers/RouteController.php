<?php

namespace App\Modules\RouteModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\RouteModule\Route;
use App\Modules\RouteModule\Controllers\RouteTrait;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    use RouteTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::get();
        return json_encode($routes);
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
        $response = $this->storeRoute($request);
        if($response['state'] == 200){
            return json_encode([
                'state' => $response['state'],
                'data' => $response['data'],
                'message' => 'Ruta creada exitosamente'
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
        $route = Route::with(['getMessenger', 'getGuide'])->find($id);
        return json_encode($route);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $route = Route::find($id);
        return json_encode($route);
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
        $response = $this->updateRoute($request->merge(['route_id' => $id]));
        if($response['state'] == 200){
            return json_encode([
                'state' => $response['state'],
                'data' => $response['data'],
                'message' => 'Ruta actualizada exitosamente'
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
        $response = $this->deleteRoute($id);
        if($response['state'] == 200){
            return json_encode([
                'state' => $response['state'],
                'message' => 'Eliminación exitosa'
            ]);
        } else {
            return json_encode($response['message']);
        }
    }
}
