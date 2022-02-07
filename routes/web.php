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
        //USER
        Route::resource('usuarios', 'Admin\UserController')->names('users');

        //CUSTOMER
        Route::resource('/clientes', 'Admin\CustomerController')->names('clientes');
        //Obtener sucursales
        Route::get('/sucursales_cliente/{id}', 'Admin\CustomerController@getBranchOffices')->name('branchOffices.index');
        //BANKS
        // Route::get('/bancos', 'Admin\CustomerController@BankIndex')->name('banks.index');

        //USER BANKS
        Route::get('/usuario-banco/{parent_id}', 'Admin\CustomerController@UserBankIndex')->name('bankUsers.index');
        Route::get('/usuario-banco/{parent_id}/create', 'Admin\CustomerController@UserBankCreate')->name('bankUsers.create');
        Route::post('/usuario-banco/{parent_id}/store', 'Admin\CustomerController@UserBankStore')->name('bankUsers.store');
        Route::get('/usuario-banco/{parent_id}/{id}', 'Admin\CustomerController@UserBankShow')->name('bankUsers.show');
        Route::get('/usuario-banco/{parent_id}/{id}/edit', 'Admin\CustomerController@UserBankEdit')->name('bankUsers.edit');
        Route::put('/usuario-banco/{parent_id}/{id}/update', 'Admin\CustomerController@UserBankUpdate')->name('bankUsers.update');
        Route::delete('/usuario-banco/{parent_id}/{id}', 'Admin\CustomerController@UserBankDestroy')->name('bankUsers.delete');

        //BRANCH OFFICES
        Route::get('/sucursales/{parent_id}', 'Admin\BranchOfficeController@index')->name('branchOffices.index');
        Route::get('/sucursales/{parent_id}/create', 'Admin\BranchOfficeController@create')->name('branchOffices.create');
        Route::post('/sucursales/{parent_id}/store', 'Admin\BranchOfficeController@store')->name('branchOffices.store');
        Route::get('/sucursales/{parent_id}/{id}', 'Admin\BranchOfficeController@show')->name('branchOffices.show');
        Route::get('/sucursales/{parent_id}/{id}/edit', 'Admin\BranchOfficeController@edit')->name('branchOffices.edit');
        Route::put('/sucursales/{parent_id}/{id}/update', 'Admin\BranchOfficeController@update')->name('branchOffices.update');
        Route::delete('sucursales/{parent_id}/{id}', 'Admin\BranchOfficeController@destroy')->name('branchOffices.delete');

        //MESSEGERS
        Route::resource('mensajeros', 'Admin\MessengerController')->names('messengers');

        //BANK DEPARTMENTS
        // Route::resource('departamentos', 'Admin\DepartmentController')->names('department');
        Route::get('departamentos/{branch_office_id}', 'Admin\DepartmentController@index')->name('departments.index');
        Route::get('departamentos/{branch_office_id}/create', 'Admin\DepartmentController@create')->name('departments.create');
        Route::post('departamentos/{branch_office_id}/store', 'Admin\DepartmentController@store')->name('departments.store');
        Route::get('departamentos/{id}/detaller', 'Admin\DepartmentController@show')->name('departments.show');
        Route::get('departamentos/{id}/edit', 'Admin\DepartmentController@edit')->name('departments.edit');
        Route::put('departamentos/{id}', 'Admin\DepartmentController@update')->name('departments.update');
        Route::delete('departamentos/{id}', 'Admin\DepartmentController@destroy')->name('departments.delete');

        //ORDENES
        Route::resource('/ordenes', 'Admin\OrderController')->names('orders');
        // Route::get('orden', function () {
        //     return view('orders.index');
        // })->name('orders.index');
        // Route::get('orden/crear', function () {
        //     return view('orders.create');
        // })->name('orders.create');

        //GUIAS
        Route::resource('/guias', 'Admin\GuideController')->names('guias');

        //DOCUMENTOS DE GUIAS
        Route::resource('/guias_doc', 'Admin\GuidanceDocumentController')->names('guias_doc');

        //RUTAS
        Route::resource('/rutas', 'Admin\RouteController')->names('rutas');
    });
});

//ADDRESSES
Route::resource('direcciones', 'Admin\AddressController')->names('addresses');
//REPORTS
Route::resource('reportes', 'Admin\ReportController')->names('reports');
//SERVICE TYPES
Route::resource('tipo-de-servicios', 'Admin\ServiceTypeController')->names('serviceTypes');
//SERVICES
Route::resource('mis-servicios', 'Admin\MyServiceController')->names('myServices');
//CHAT
Route::resource('chat', 'Admin\ChatController')->names('chats');
