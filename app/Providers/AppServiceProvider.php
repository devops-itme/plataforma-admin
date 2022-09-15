<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Modules\UserModule\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //ORDENES

        Gate::define('Orders', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '2')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            //  dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //ORDENES INTERNACIONALES

        Gate::define('InternationalOrders', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '4')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //CLIENTES

        Gate::define('Customers', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '6')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //MENSAJEROS

        Gate::define('Messengers', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '11')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });

        //USUARIOS

        Gate::define('Users', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '12')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //PARAMETROS

        Gate::define('Parameters', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '13')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //TARIFAS

        Gate::define('Rates', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '14')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //ZONAS

        Gate::define('Zones', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '15')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //HORAS

        Gate::define('Hours', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '18')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });



        //MATRIZ DE ESTADOS

        Gate::define('StatusMatrix', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '17')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            // dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });


        //DESPACHOS PACKING

        Gate::define('DeliveryPacking', function () {

            $permisos =  DB::table('permissions AS p')
                ->select(
                    'p.id',
                    'p.role_id',
                    'p.module_id',
                    'p.actions',
                    'm.reference'
                )
                ->join('roles as r', 'p.role_id', '=', 'r.id')
                ->join('modules as m', 'm.id', '=', 'p.module_id')
                ->join('users as u', 'u.role', '=', 'r.id')
                ->where('u.id', Auth::user()->id)
                ->where('p.module_id', '=', '19')
                ->get();

            foreach ($permisos as $permiso) {
                $guardar[] = $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
            }
            //  dd($guardar);

            if (isset($modulo_permission)) {
                return false;
            }
            return true;
        });
    }
}
