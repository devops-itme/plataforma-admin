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
    Route::get('/customer_data/{id}', 'Admin\CustomerController@customerData');
    Route::get('/search_customers', 'Admin\CustomerController@search_customer');
    Route::get('/unassigned_branch_offices', 'Admin\BranchOfficeController@unassigned_branch_offices');
    Route::get('/order_number', 'Admin\OrderController@orderNumber');

    Route::get('/allBranches', 'Admin\BranchOfficeController@allBranches');

    Route::get('unassigned_depts', 'Admin\DepartmentController@UnassignedDepts');

    Route::get('/customer_addresses/{id}', 'Admin\AddressController@customerAddresses');
    //GUIAS
    Route::resource('/guias', 'Admin\GuideController')->names('guias')->except('store');
    Route::post('/guias/store', 'Admin\GuideController@store')->name('guide.store');
    Route::post('/ordenes/asignacion', 'Admin\DeliveryController@assignateOndemad')->name('orders.assignate');
    Route::post('/quias/asignacion', 'Admin\DeliveryController@assignatePacking')->name('guides.assignate');

    Route::group(['middleware' => 'role'], function () {
        //USER
        Route::resource('usuarios', 'Admin\UserController')->names('users');

        //CUSTOMER
        Route::resource('/clientes', 'Admin\CustomerController')->names('customers');
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
        Route::resource('departamentos', 'Admin\DepartmentController')->names('departments');

        //ORDENES
        Route::resource('/ordenes', 'Admin\OrderController')->names('orders');

        //DOCUMENTOS DE GUIAS
        Route::resource('/guias_doc', 'Admin\GuidanceDocumentController')->names('guias_doc');


    });
    //Orders states
    Route::get('order_states', 'Admin\DeliveryController@orderStates');
    //Orders delivery
    Route::get('orders_ondemand/{type}', 'Admin\OrderController@ordersForDelivery');
    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'Admin\OrderController@ordersForDeliveryMultiples');
    //Messengers delivery
    Route::get('messengers_delivery', 'Admin\MessengerController@messengersForDelivery');


    Route::get('despachos', 'Admin\DeliveryController@indexOndemand')->name('delivery.index');
    Route::get('despachos-packing', 'Admin\DeliveryController@indexPacking')->name('deliveryPacking.index');

    Route::get('zonas', function () {
        return view('zones.index');
    })->name('zone.index');

    Route::get('perfil', function () {
        return view('profile.index');
    })->name('profile');

    Route::resource('permisos', 'Admin\PermissionController')->names('permits');
    Route::get('permisos/getPermissions/{role_id}', 'Admin\PermissionController@getPermissions')->name('permits.getPermissions');
    Route::get('despachos', function () {
        return view('deliveries.index');
    })->name('delivery.index');
    Route::get('despachos-packing', function () {
        return view('deliveriesPacking.index');
    })->name('deliveryPacking.index');
    Route::get('zonas', function () {
        return view('zones.index');
    })->name('zone.index');

    Route::get('planes', function () {
        return view('plans.index');
    })->name('plans.index');

    Route::get('historial', function () {
        return view('orders.historial');
    })->name('historial.index');

});
//RUTAS
Route::resource('/rutas', 'Admin\RouteController')->names('routes');
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
