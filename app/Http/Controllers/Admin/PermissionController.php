<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Module;
use App\Parameter;
use App\ParameterValue;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

        return $this->respond(200, ['modules' => $modules, 'permissions' =>  $permissions, 'actions' =>  $actions], null, 'Roles yPermisos');
    }

    public function update(Request $request, $role_id)
    {
        try {
            foreach ($request->all() as $key => $item) {
                if ($key == '_token' || $key == '_method' || $key == 'dashboard') {
                    continue;
                }
                $module = Module::where('reference', $key)->first();
                $permission = Permission::where('role_id', $role_id)
                    ->where('module_id', $module->id)
                    ->first();

                $actions = implode(',', $item);
                $permission->update([
                    'actions' => $actions
                ]);
                return redirect()->back()->with('success', 'Permisos actualizados exitosamente');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('danger', 'Error al actualizar permisos');
        }
    }
}
