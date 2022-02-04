<?php

namespace App\Http\Middleware;

use App\Module;
use App\ParameterValue;
use App\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module, $action)
    {
        $role_id = Auth::user()->role;
        $module = Module::where('name', $module);
        $module_id = $module->id;
        $action = ParameterValue::where('name', $action);
        $action_id = $action->id;
        $premission = Permission::where('module_id', $module_id)->where('role_id', $role_id)->first(['actions']);
        if(!in_array($action_id,$premission)){

        }

        return $next($request);
    }
}
