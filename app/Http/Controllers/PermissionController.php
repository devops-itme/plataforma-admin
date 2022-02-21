<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RestActions;
use App\Module;
use App\Parameter;
use App\ParameterValue;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    use RestActions;

    public function index()
    {
        $roles = Role::get();
        $permissions = Permission::get();
        // dd($permissions);
        return view('permits', compact('roles'));
    }

    public function getPermissions($role_id)
    {
        $modules = Module::get();
        $permissions = Permission::where('role_id', $role_id)->get();

        $action = Parameter::where('name', 'action')->first();
        $actions = ParameterValue::where('parameter_id', $action->id)->get(['id', 'name']);
        // dd($permissions);
        return $this->respond(200, ['modules' => $modules, 'permissions' =>  $permissions, 'actions' =>  $actions], null, 'Roles yPermisos');
    }

    public function update(Request $request, $role_id)
    {
        dd($role_id, $request->all());
          $validation = Validator::make($request->all(), [
             'role_id' => 'required',
             'permits' => 'array|nullable'
          ], [
             'role_id.required' => 'Formato incorrecto',
             'permits.array' => 'Formato incorrecto'
          ]);

        //   if ($validation->fails()) {
        //      Session::flash('warning', $validation->errors()->first());
        //      return back()->withInput();
        //   }

        //   $permission = $this->permissionStore($request);
        //   if ($permission['status']==200) {
        //      Session::flash('success', 'Permiso actualizado correctamente');
        //      return back();
        //   }else{
        //      if ($permission['status']!=0) {$message = $permission['message'];
        //      }else{$message = "Estamos presentando inconvenientes en este momento";}

        //      Session::flash('warning', $message);
        //      return back()->withInput();
        //   }
    }
}
