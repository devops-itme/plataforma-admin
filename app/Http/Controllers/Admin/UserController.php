<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserTrait;
use App\ParameterValue;
use App\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UserTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->getUser();
        $users = $users['data']->whereIn('role',[1,2]);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document_types = ParameterValue::where('parameter_id', 1)->get();
        $roles = Role::where('state', 1)->whereIn('id', [1, 2])->get();
        return view('users.create', compact('document_types' , 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->saveUser($request);

        if($user['state'] == 200){
            return redirect()->route('users.index')->with('success', 'Usuario registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('danger', $user['error']);
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->showUser($id);
        $user = $user['data'];
        $roles = Role::where('state', 1)->whereIn('id', [1, 2])->get();
        $document_types = ParameterValue::where('parameter_id', 1)->get();
        return view('users.edit', compact('user', 'roles', 'document_types'));
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
        request()->merge([
            'user_id' => $id
        ]);
        $response = $this->updateUser($request, $id);
        if($response['state'] == 200){
            return redirect()->route('users.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
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
        $response = $this->deleteUser($id);
        if($response['state'] == 200){
            return redirect()->route('users.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
