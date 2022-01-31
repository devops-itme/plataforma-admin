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
    Route::get('/bancos', 'Admin\CustomerController@BankIndex')->name('banks.index');
    Route::get('/bancos/{parent_id?}/create', 'Admin\CustomerController@BankCreate')->name('banks.create');
    Route::post('/bancos/{parent_id?}/store', 'Admin\CustomerController@BankStore')->name('banks.store');

    //MESSEGERS
    Route::resource('mensajeros', 'Admin\MessengerController')->names('messenger');

});
