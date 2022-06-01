<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/clientes', function () {
//     return view('customers.index');
// })->name('customer.index');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    
    Route::group(['middleware' => 'role'], function () {
       
    });
  
    Route::get('notificaciones', function () {
        return view('notifications.index');
    })->name('notificaciones.index');

    Route::get('todasnotificaciones', function () {
        return view('notifications.seeAll');
    })->name('todasnotificaciones.index');
    
    
    Route::get('{page}', 'PageController@index')->name('page.index');
    //RUTAS
    // Route::resource('/rutas', 'Admin\RouteController')->names('routes');
    // Route::resource('/rutas', 'RouteModule\Controllers\RouteController')->names('routes');
});
// Route::get('admin/order', 'Admin\OrderController@historial');

//ADDRESSES
// Route::resource('direcciones', 'Admin\AddressController')->names('addresses');
// Route::resource('direcciones', 'AddressModule\Controllers\AddressController')->names('addresses');

//REPORTS
// Route::resource('reportes', 'Admin\ReportController')->names('reports'); //DELETE REPORTS