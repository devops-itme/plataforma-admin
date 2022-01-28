<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::resource('/clientes', 'Admin\CustomerController');
// Route::get('/clientes', function () {
//     return view('customers.index');
// })->name('customer.index');

// Route::get('/clientes/crear', function () {
//     return view('customers.create');
// })->name('customer.create');

Route::get('/clientes/ver', function () {
    return view('customers.show');
})->name('customer.show');

Route::get('/clientes/editar', function () {
    return view('customers.edit');
})->name('customer.edit');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
