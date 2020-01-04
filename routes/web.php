<?php

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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

////CRUD Clientes

Route::get('/clientes','ClientesController@index')->name('clientes');
Route::post('/registrarClientes','ClientesController@store')->name('clientes.store');
Route::post('/borrarClientes','ClientesController@destroy')->name('clientes.delete');
Route::post('/actualizarClientes','ClientesController@update')->name('clientes.update');

////CRUD Servicios

Route::get('/servicios','ServiciosController@index')->name('servicios');
Route::post('/registrarServicios','ServiciosController@store')->name('servicios.store');
Route::post('/borrarServicios','ServiciosController@destroy')->name('servicios.delete');
Route::post('/actualizarServicios','ServiciosController@update')->name('servicios.update');