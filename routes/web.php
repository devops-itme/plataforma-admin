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

//ORDERS
Route::resource('/ordenes', 'Admin\OrderController')->names('ordenes');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    //USER
    Route::resource('usuarios', 'Admin\UserController')->names('user');
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

    //BRANCH OFFICES
    Route::get('/sucursales/{parent_id}', 'Admin\BranchOfficeController@index')->name('branchOffices.index');
    Route::get('/sucursales/{parent_id}/create', 'Admin\BranchOfficeController@create')->name('branchOffices.create');
    Route::post('/sucursales/{parent_id}/store', 'Admin\BranchOfficeController@store')->name('branchOffices.store');
    Route::get('/sucursales/{parent_id}/{id}', 'Admin\BranchOfficeController@show')->name('branchOffices.show');
    Route::get('/sucursales/{parent_id}/{id}/edit', 'Admin\BranchOfficeController@edit')->name('branchOffices.edit');
    Route::put('/sucursales/{parent_id}/{id}/update', 'Admin\BranchOfficeController@update')->name('branchOffices.update');
    Route::delete('sucursales/{parent_id}/{id}', 'Admin\BranchOfficeController@destroy')->name('branchOffices.delete');

    //MESSEGERS
    Route::resource('mensajeros', 'Admin\MessengerController')->names('messenger');

    //BANK DEPARTMENTS
    // Route::resource('departamentos', 'Admin\DepartmentController')->names('department');
    Route::get('departamentos/{branch_office_id}', 'Admin\DepartmentController@index')->name('department.index');
    Route::get('departamentos/{branch_office_id}/create', 'Admin\DepartmentController@create')->name('department.create');
    Route::post('departamentos/{branch_office_id}/store', 'Admin\DepartmentController@store')->name('department.store');
    Route::get('departamentos/{id}/detaller', 'Admin\DepartmentController@show')->name('department.show');
    Route::get('departamentos/{id}/edit', 'Admin\DepartmentController@edit')->name('department.edit');
    Route::put('departamentos/{id}', 'Admin\DepartmentController@update')->name('department.update');
    Route::delete('departamentos/{id}', 'Admin\DepartmentController@destroy')->name('department.destroy');

});

//ADDRESSES
Route::resource('direcciones', 'Admin\AddressController')->names('address');
//REPORTS
Route::resource('reportes', 'Admin\ReportController')->names('report');
//SERVICE TYPES
Route::resource('tipo-de-servicios', 'Admin\ServiceTypeController')->names('serviceType');

