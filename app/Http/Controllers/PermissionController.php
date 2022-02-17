<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RestActions;
use App\Module;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

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
        $roles = Role::get();
        $modules = Module::get();
        $permissions = Permission::where('role_id', $role_id)->get();
        // dd($permissions);
        return $this->respond(200, ['roles' => $roles, 'modules' => $modules, 'permissions' =>  $permissions], null, 'Roles yPermisos');
    }
}
