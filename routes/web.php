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
    return view('auth.login');
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

Route::get('/usuarios', function () {
    return view('users.index');
})->name('user.index');

Route::get('/usuarios/crear', function () {
    return view('users.create');
})->name('user.create');

Route::get('/usuarios/editar', function () {
    return view('users.edit');
})->name('user.edit');

//MESSEGERS
Route::resource('mensajeros', 'Admin\MessengerController')->names('messenger');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

