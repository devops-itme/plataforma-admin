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
    Route::post('/ordenes/asignacion', 'Admin\DeliveryController@assignOndemad')->name('orders.assign');
    Route::post('/quias/asignacion', 'Admin\DeliveryController@assignPacking')->name('guides.assign');
    //update order state
    Route::post('/despacho/orden/estado', 'Admin\DeliveryController@updateStateOrders');

    Route::resource('parametros', 'Admin\ParameterController')->except('destroy')->names('parameters');
    Route::delete('parametros/delete/{id}', 'Admin\ParameterController@destroy')->name('parameters.destroy');

    Route::group(['middleware' => 'role'], function () {
        //USER
        Route::resource('usuarios', 'Admin\UserController')->names('users');

        //CUSTOMER
        Route::resource('/clientes', 'Admin\CustomerController')->except('store')->names('customers');
        Route::post('/clientes/store', 'Admin\CustomerController@store')->name('customers.store');
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
        // Route::get('ordenes/historial', function () {
        //     return view('orders.historial');
        // })->name('orders.record');
        Route::get('/ordenes/historial', 'Admin\OrderController@record')->name('orders.record');
        Route::resource('/ordenes', 'Admin\OrderController')->names('orders');

        //DOCUMENTOS DE GUIÁS
        Route::resource('/guias_doc', 'Admin\GuidanceDocumentController')->names('guias_doc');


    });

    //Por despachar ondemand
    Route::post('pordespachar/ondemand/{id}', 'Admin\OrderController@porDespacharOndemand');
    //Por despachar packaging
    Route::post('pordespachar/packaging/{id}', 'Admin\GuideController@porDespacharPackaging');



    //Orders states
    Route::get('order_states', 'Admin\DeliveryController@orderStates');
    //Orders delivery
    Route::get('orders_ondemand/{type}', 'Admin\OrderController@ordersForDelivery');
    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'Admin\GuideController@guidesForDeliveryPacking');
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
    Route::resource('roles', 'Admin\RoleController')->names('roles');
    // Route::post('roles/store', 'Admin\PermissionController@storeRole')->name('permits.role');
    Route::get('permisos/getPermissions/{role_id}', 'Admin\PermissionController@getPermissions')->name('permits.getPermissions');

    Route::get('planes', function () {
        return view('plans.index');
    })->name('plans.index');

    //Matriz de estados del despacho lógica
    Route::get('despacho/matriz_estados', 'Admin\DeliveryController@statusMatrix');

    //Status matrix
    Route::get('matriz-estados', 'Admin\StatusMatrixController')->names('statusMatrix.index');
});
//RUTAS
Route::resource('/rutas', 'Admin\RouteController')->names('routes');
// Route::get('admin/order', 'Admin\OrderController@historial');
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
