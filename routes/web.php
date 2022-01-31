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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {


    //CUSTOMER
    Route::resource('/clientes', 'Admin\CustomerController');
    Route::get('/usuarios/{parent_id?}/create', 'Admin\CustomerController@UserCreate')->name('user.create');
    Route::post('/usuarios/{parent_id?}/store', 'Admin\CustomerController@UserStore')->name('user.store');

    //MESSEGERS
    Route::resource('mensajeros', 'Admin\MessengerController')->names('messenger');

});
