<?php

use Illuminate\Support\Facades\Route;
//NATIONAL ORDER
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('order/markAsRead', 'OrderModule\Controllers\Api\OrderController@markAsRead');
    Route::resource('orders', 'OrderModule\Controllers\Api\OrderController')->names('order');
    Route::put('order/finishOrder', 'OrderModule\Controllers\Api\OrderController@finishOrder')->name('order.finishOrder');
    Route::put('order/changeStatus', 'OrderModule\Controllers\Api\OrderController@changeStatus')->name('order.changeStatus');

    Route::get('order/delivery-courier/record', 'OrderModule\Controllers\Api\OrderController@CourierOrderHistory')->name('order.CourierOrderHistory');
    Route::get('order/webview/paguelo-facil', 'OrderModule\Controllers\Api\OrderController@webviewPagueloFacil')->name('order.webview');
});
Route::get('order/webview/paguelo-facil/response', 'OrderModule\Controllers\Api\OrderController@responseViewPagueloFacil')->name('order.webview.response');
Route::get('sendPushNotification', 'OrderModule\Controllers\Api\OrderController@sendPushNotification')->name('order.sendPushNotification');


//INTERNATIONAL ORDER
Route::middleware(['auth:sanctum'])->group(function () {
    if (auth('sanctum')->check()) {
            // Route::resource('internationalOrders', 'OrderModule\Controllers\Api\InternationalOrderController')->names('internationalOrder');
    Route::get('internationalOrder/updateGuideByTealca', 'OrderModule\Controllers\Api\InternationalOrderController@updateGuideByTealca');
    Route::get('internationalOrder/index', 'OrderModule\Controllers\Api\InternationalOrderController@index')->name('internationalOrder.index');
    Route::get('internationalOrder/services', 'OrderModule\Controllers\Api\InternationalOrderController@services')->name('internationalOrder.services');
    Route::post('internationalOrder/create', 'OrderModule\Controllers\Api\InternationalOrderController@store')->name('internationalOrder.create');
    Route::get('internationalOrder/detail/{id}', 'OrderModule\Controllers\Api\InternationalOrderController@show')->name('internationalOrder.detail');
    Route::get('internationalOrder/getExportedDocumentsByUser', 'OrderModule\Controllers\Api\InternationalOrderController@getExportedDocumentsByUser');
    Route::get('internationalOrder/getExportedDocumentsbyAuth', 'OrderModule\Controllers\Api\InternationalOrderController@getExportedDocumentsByAuth');
    Route::post('web/export/order', 'OrderModule\Controllers\Api\InternationalOrderController@exportGuide')->name('internationalOrder.export');

    Route::get('testing-data', 'OrderModule\Controllers\Api\InternationalOrderController@testing');
    }
});

Route::any('{any}', function(){
    return response()->json([
        'status'    => 404,
        'message'   => 'Ruta no encontrada.',
    ], 404);
})->where('any', '.*');



