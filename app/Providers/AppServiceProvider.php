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

        Gate::define('Orders',function(){

            $permisos=  DB::table('permissions AS p')
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
            ->where('u.id',Auth::user()->id)
            ->where('p.module_id','=', '2')
            ->get();

            foreach ($permisos as $permiso) {
              $guardar[]= $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
              }
          //  dd($guardar);

            if( isset($modulo_permission) ){
                return false;
            }
            return true;
         });


         //ORDENES INTERNACIONALES

        Gate::define('InternationalOrders',function(){

            $permisos=  DB::table('permissions AS p')
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
            ->where('u.id',Auth::user()->id)
            ->where('p.module_id','=', '4')
            ->get();

            foreach ($permisos as $permiso) {
              $guardar[]= $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
              }
            // dd($guardar);

            if( isset($modulo_permission) ){
                return false;
            }
            return true;
         });



        //MATRIZ DE ESTADOS

        Gate::define('StatusMatrix',function(){

            $permisos=  DB::table('permissions AS p')
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
            ->where('u.id',Auth::user()->id)
            ->where('p.module_id','=', '17')
            ->get();

            foreach ($permisos as $permiso) {
              $guardar[]= $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
              }
           // dd($guardar);

            if( isset($modulo_permission) ){
                return false;
            }
            return true;
         });


        //DESPACHOS PACKING

        Gate::define('DeliveryPacking',function(){

            $permisos=  DB::table('permissions AS p')
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
            ->where('u.id',Auth::user()->id)
            ->where('p.module_id','=', '19')
            ->get();

            foreach ($permisos as $permiso) {
              $guardar[]= $permiso->actions;
            }

            foreach ($guardar as $accion) {
                if ($accion != 6) {
                    $modulo_permission = $accion;
                }
              }
          //  dd($guardar);

            if( isset($modulo_permission) ){
                return false;
            }
            return true;
         });
    }
}
