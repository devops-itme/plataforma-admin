<?php

namespace App\Modules\UserModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\UserModule\Controllers\UserTrait;
use App\ParameterValue;
use App\Role;
use App\Modules\UserModule\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UserTrait;

    protected $path = 'UserModule.views.html.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::name(request()->name)
            ->document(request()->document)
            ->email(request()->email)
            ->phone(request()->phone)
            ->role(request()->role_id)
            ->state(request()->state)
            ->whereHas('getRole', function ($q) {
                $q->whereNotIn('name', ['Cliente', 'Mensajero']);
            })
            ->paginate(10);

        $roles = Role::where('state', 1)->whereNotIn('name', ['Cliente', 'Mensajero'])->get();

        return view($this->path . 'index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document_types = ParameterValue::whereHas('getParameter', function ($q) {
            $q->where('name', 'document_type');
        })->get();
        $roles = Role::where('state', 1)->whereNotIn('name', ['Cliente', 'Mensajero'])->get();
        return view($this->path .  'create', compact('document_types', 'roles'));
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

        if ($user['state'] == 200) {
            return redirect()->route('users.index')->with('success', 'Usuario registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('danger', $user['message']);
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
        $user = $this->showUser($id);
        $user = $user['data'];
        $roles = Role::where('state', 1)->whereIn('id', [1, 2])->get();
        $document_types = ParameterValue::where('parameter_id', 1)->get();
        return view($this->path .  'detail', compact('user', 'roles', 'document_types'));
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
        return view($this->path .  'edit', compact('user', 'roles', 'document_types'));
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
        if ($response['state'] == 200) {
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
    public function destroy(Request $request, $id)
    {
        $response = $this->deleteUser($id);
        if ($request->response_format == 'json') {
            return $response;
        }
        if ($response['state'] == 200) {
            return redirect()->route('users.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('danger', $response['message']);
        }
    }
}
