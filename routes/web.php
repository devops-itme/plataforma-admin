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
    //BANKS
    Route::get('/bancos', 'Admin\CustomerController@BankIndex')->name('banks.index');

    //USER BANKS
    Route::get('/userBanks/{parent_id}', 'Admin\CustomerController@UserBankIndex')->name('userBanks.index');
    Route::get('/userBanks/{parent_id}/create', 'Admin\CustomerController@UserBankCreate')->name('userBanks.create');
    Route::post('/userBanks/{parent_id}/store', 'Admin\CustomerController@UserBankStore')->name('userBanks.store');
    Route::get('/userBanks/{parent_id}/{id}', 'Admin\CustomerController@UserBankShow')->name('userBanks.show');
    Route::get('/userBanks/{parent_id}/{id}/edit', 'Admin\CustomerController@UserBankEdit')->name('userBanks.edit');
    Route::put('/userBanks/{parent_id}/{id}/update', 'Admin\CustomerController@UserBankUpdate')->name('userBanks.update');
    Route::delete('/userBanks/{parent_id}/{id}', 'Admin\CustomerController@UserBankDestroy')->name('userBanks.destroy');

    //MESSEGERS
    Route::resource('mensajeros', 'Admin\MessengerController')->names('messenger');

    Route::get('/usuarios', function () {
        return view('users.index');
    })->name('user.index');

    Route::get('/usuarios/crear', function () {
        return view('users.create');
    })->name('user.create');

    Route::get('/usuarios/editar', function () {
        return view('users.edit');
    })->name('user.edit');

});
