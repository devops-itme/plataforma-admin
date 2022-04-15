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
    // Route::get('/order_number', 'Admin\OrderController@orderNumber');
    Route::get('/order_number', 'OrderModule\Controllers\OrderController@orderNumber');

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

    // Route::resource('parametros', 'Admin\ParameterController')->except('destroy')->names('parameters');
    // Route::delete('parametros/delete/{id}', 'Admin\ParameterController@destroy')->name('parameters.destroy');
    Route::resource('parametros', 'ParametersModule\Controllers\ParameterController')->except('destroy')->names('parameters');
    Route::delete('parametros/delete/{id}', 'ParametersModule\Controllers\ParameterController@destroy')->name('parameters.destroy');
    Route::group(['middleware' => 'role'], function () {
        //USER
        // Route::resource('usuarios', 'Admin\UserController')->names('users');
        Route::resource('usuarios', 'UserModule\Controllers\UserController')->names('users');


        //CUSTOMER
        Route::resource('/clientes', 'CustomerModule\Controllers\CustomerController')->except('store')->names('customers');
        Route::post('/clientes/store', 'CustomerModule\Controllers\CustomerController@store')->name('customers.store');
        // Route::resource('/clientes', 'Admin\CustomerController')->except('store')->names('customers');
        // Route::post('/clientes/store', 'Admin\CustomerController@store')->name('customers.store');
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
        // Route::resource('mensajeros', 'MessengerController@index')->names('messengers');
        Route::resource('mensajeros', 'MessengerModule\Controllers\MessengerController')->names('messengers');

        //BANK DEPARTMENTS
        // Route::resource('departamentos', 'Admin\DepartmentController')->names('departments');
        Route::resource('departamentos', 'DepartmentModule\Controllers\DepartmentController')->names('departments');

        //ORDENES
        // Route::get('ordenes/historial', function () {
        //     return view('orders.historial');
        // })->name('orders.record');
        // Route::get('/ordenes/historial', 'Admin\OrderController@record')->name('orders.record');
        Route::get('/ordenes/historial', 'OrderModule\Controllers\OrderController@record')->name('orders.record');
        // Route::resource('/ordenes', 'Admin\OrderController')->names('orders');
        Route::resource('/ordenes', 'OrderModule\Controllers\OrderController')->names('orders');

        //DOCUMENTOS DE GUIÁS
        Route::resource('/guias_doc', 'Admin\GuidanceDocumentController')->names('guias_doc');
    });
    //Status matrix
    // Route::get('matriz-estados', 'Admin\StatusMatrixController@index')->name('statusMatrix.index');
    Route::get('matriz-estados', 'StatusMatrixModule\Controllers\StatusMatrixController@index')->name('statusMatrix.index');


    //Status Descriptor
    // Route::get('descriptor-estado/{id}', 'Admin\StatusDescriptorController@index')->name('statusDescriptor.index');
    // //Store
    // Route::post('descriptor-estado/{id}', 'Admin\StatusDescriptorController@store')->name('statusDescriptor.store');
    // Route::delete('descriptor-estado/{id}', 'Admin\StatusDescriptorController@destroy')->name('statusDescriptor.destroy');

    //Por despachar ondemand
    // Route::post('pordespachar/ondemand/{id}', 'Admin\OrderController@porDespacharOndemand');
    Route::post('pordespachar/ondemand/{id}', 'OrderModule\Controllers\OrderController@porDespacharOndemand');
    //Por despachar packaging
    Route::post('pordespachar/packaging/{id}', 'Admin\GuideController@porDespacharPackaging');



    //Orders states
    Route::get('order_states', 'Admin\DeliveryController@orderStates');
    //Orders delivery
    // Route::get('orders_ondemand/{type}', 'Admin\OrderController@ordersForDelivery');
    Route::get('orders_ondemand/{type}', 'OrderModule\Controllers\OrderController@ordersForDelivery');
    //Orders Delivery Packing
    Route::get('orders_packing/{type}', 'Admin\GuideController@guidesForDeliveryPacking');
    //Messengers delivery
    Route::get('messengers_delivery', 'Admin\MessengerController@messengersForDelivery');


    Route::get('despachos', 'Admin\DeliveryController@indexOndemand')->name('delivery.index');
    Route::get('despachos-packing', 'Admin\DeliveryController@indexPacking')->name('deliveryPacking.index');

    // Route::get('getPlaces', 'Admin\PlaceController@getPlaces');
    // Route::get('getZoneNeighborhoods/{id}', 'Admin\PlaceController@getZoneNeighborhoods');
    // Route::resource('zonas', 'Admin\ZoneController')->names('zones');
    Route::resource('zonas', 'ZoneModule\Controllers\ZoneController')->names('zones');
    Route::get('getPlaces', 'ZoneModule\Controllers\PlaceController@getPlaces');
    Route::get('getZoneNeighborhoods/{id}', 'ZoneModule\Controllers\PlaceController@getZoneNeighborhoods');

    Route::get('notificaciones', function () {
        return view('notifications.index');
    })->name('notificaciones.index');

    Route::get('todasnotificaciones', function () {
        return view('notifications.seeAll');
    })->name('todasnotificaciones.index');

    Route::get('ordenes-listado', function () {
        return view('orders.list');
    })->name('Ordenes.Listado.index');

    Route::resource('tarifas', 'Admin\RateController')->names('rates');

    Route::resource('perfil', 'Admin\ProfileController')->names('profile');
    // Route::get('perfil', function () {

    // })->name('profile');

    // Route::resource('permisos', 'Admin\PermissionController')->names('permits');
    // Route::resource('roles', 'Admin\RoleController')->names('roles');
    // Route::post('roles/store', 'Admin\PermissionController@storeRole')->name('permits.role');
    // Route::get('permisos/getPermissions/{role_id}', 'Admin\PermissionController@getPermissions')->name('permits.getPermissions');

    Route::resource('permisos', 'PermissionModule\Controllers\PermissionController')->names('permits');
    Route::resource('roles', 'RoleModule\Controllers\RoleController')->names('roles');
    Route::get('permisos/getPermissions/{role_id}', 'PermissionModule\Controllers\PermissionController@getPermissions')->name('permits.getPermissions');

    Route::resource('planes', 'Admin\PlanController')->names('plans');

    //Matriz de estados del despacho lógica
    Route::get('despacho/matriz_estados', 'Admin\DeliveryController@statusMatrix');

    // Route::resource('horas', 'Admin\PickupHourController')->except('delete')->names('hours');
    // Route::delete('horas/{id}', 'Admin\PickupHourController@destroy')->name('hours.delete');
    // Route::get('/getPickupHours', 'Admin\PickupHourController@pickupHours');
    Route::resource('horas', 'PickupHourModule\Controllers\PickupHourController')->except('delete')->names('hours');
    Route::delete('horas/{id}', 'PickupHourModule\Controllers\PickupHourController@destroy')->name('hours.delete');
    Route::get('/getPickupHours', 'PickupHourModule\Controllers\PickupHourController@pickupHours');

    // Route::get('log', 'Admin\LogController@index')->name('log.index');
    Route::get('log', 'ActivityLogModule\Controllers\LogController@index')->name('log.index');

    Route::get('{page}', 'PageController@index')->name('page.index');
});
//RUTAS
Route::resource('/rutas', 'Admin\RouteController')->names('routes');
// Route::get('admin/order', 'Admin\OrderController@historial');

//ADDRESSES
// Route::resource('direcciones', 'Admin\AddressController')->names('addresses');
Route::resource('direcciones', 'AddressModule\Controllers\AddressController')->names('addresses');

//REPORTS
Route::resource('reportes', 'Admin\ReportController')->names('reports');
//SERVICE TYPES
Route::resource('tipo-de-servicios', 'Admin\ServiceTypeController')->names('serviceTypes');
//SERVICES
Route::resource('mis-servicios', 'Admin\MyServiceController')->names('myServices');
//CHAT
Route::resource('chat', 'Admin\ChatController')->names('chats');
