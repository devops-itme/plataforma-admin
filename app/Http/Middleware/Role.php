<?php

namespace App\Http\Middleware;

use App\Modules\ModuleModule\Module;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\PermissionModule\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //module reference
        $pathRoute = explode('.', $request->route()->getName())[0];
        //  dd($pathRoute);
        $module = Module::where('reference', $pathRoute)->select('id')->get();

        foreach ($module as $item) {
            $module_id = $item->id;
        }
        //   dd($module_id);

        //role _id of authenticated user
        $role_id = Auth::user()->role;

        //allowed actions
        $premission = Permission::where('module_id', $module_id)->where('role_id', $role_id)->first(['id', 'actions']);
        $actions = $premission->actions ?? '';

        //action name
        // $action = $request->route()->getActionMethod();
        $action = explode('.', $request->route()->getName())[1];

        // dd($action);
        $action = ParameterValue::where('name', $action)->first(['id']);
        $action_id = $action->id;

        // dd($action_id);

        if (!in_array($action_id, explode(',', $actions))) {
            // Session::flash('warning', 'Lo siento, no tienes permiso.');
            return back();
        }

        return $next($request);
    }
}
