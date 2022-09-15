<?php

namespace App\Modules\PermissionModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ModuleModule\Module;
use App\Modules\ParametersModule\Parameter;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\PermissionModule\Permission;
use App\Modules\RoleModule\Role;
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
        return view('permits.permits', compact('roles'));
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
                //dd($key);
                // dd($request->all());
                if ($key == '_token' || $key == '_method') {
                    continue;
                }

                //Dashboard

                if ($request->has('dashboard')) {
                    if ($key == 'dashboard') {
                        $module = Module::where('reference', 'dashboard')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'dashboard')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Ordenes

                if ($request->has('orders')) {
                    if ($key == 'orders') {
                        $module = Module::where('reference', 'orders')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'orders')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Guias

                if ($request->has('guides')) {
                    if ($key == 'guides') {
                        $module = Module::where('reference', 'guides')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'guides')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Ordenes Internacionales

                if ($request->has('internationalOrders')) {
                    if ($key == 'internationalOrders') {
                        $module = Module::where('reference', 'internationalOrders')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'internationalOrders')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Envios

                if ($request->has('shipments')) {
                    if ($key == 'shipments') {
                        $module = Module::where('reference', 'shipments')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'shipments')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Clientes

                if ($request->has('customers')) {
                    if ($key == 'customers') {
                        $module = Module::where('reference', 'customers')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'customers')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Usuarios banco

                if ($request->has('bankUsers')) {
                    if ($key == 'bankUsers') {
                        $module = Module::where('reference', 'bankUsers')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    } else {
                        $module = Module::where('reference', 'bankUsers')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = '';
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                }

                //Sucursales

                if ($request->has('branchOffices')) {
                    if ($key == 'branchOffices') {
                        $module = Module::where('reference', 'branchOffices')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'branchOffices')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Departamentos

                if ($request->has('departments')) {
                    if ($key == 'departments') {
                        $module = Module::where('reference', 'departments')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'departments')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Direcciones

                if ($request->has('addresses')) {
                    if ($key == 'addresses') {
                        $module = Module::where('reference', 'addresses')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'addresses')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Mensajeros

                if ($request->has('messengers')) {
                    if ($key == 'messengers') {
                        $module = Module::where('reference', 'messengers')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'messengers')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Usuarios

                if ($request->has('users')) {
                    if ($key == 'users') {
                        $module = Module::where('reference', 'users')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'users')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Parametros

                if ($request->has('parameters')) {
                    if ($key == 'parameters') {
                        $module = Module::where('reference', 'parameters')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'parameters')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Tarifas

                if ($request->has('rates')) {
                    if ($key == 'rates') {
                        $module = Module::where('reference', 'rates')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'rates')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Zonas

                if ($request->has('zones')) {
                    if ($key == 'zones') {
                        $module = Module::where('reference', 'zones')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();

                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'zones')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Informes

                if ($request->has('reports')) {
                    if ($key == 'reports') {
                        $module = Module::where('reference', 'reports')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'reports')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Matriz Estado

                if ($request->has('statusMatrix')) {
                    if ($key == 'statusMatrix') {
                        $module = Module::where('reference', 'statusMatrix')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'statusMatrix')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }

                //Horas

                if ($request->has('hours')) {
                    if ($key == 'hours') {
                        $module = Module::where('reference', 'hours')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'hours')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }


                //Despachos Packing

                if ($request->has('deliveryPacking')) {
                    if ($key == 'deliveryPacking') {
                        $module = Module::where('reference', 'deliveryPacking')->first();
                        $permission = Permission::where('role_id', $role_id)
                            ->where('module_id', $module->id)
                            ->first();
                        $actions = implode(',', $item);
                        $permission->update([
                            'actions' => $actions
                        ]);
                    }
                } else {
                    $module = Module::where('reference', 'deliveryPacking')->first();
                    $permission = Permission::where('role_id', $role_id)
                        ->where('module_id', $module->id)
                        ->first();
                    $actions = '';
                    $permission->update([
                        'actions' => $actions
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Permisos actualizados exitosamente');
        } catch (\Throwable $e) {
            return redirect()->back()->with('danger', 'Error al actualizar permisos');
        }
    }
}
