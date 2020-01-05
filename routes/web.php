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

////CRUD Afiliaciones

Route::get('/afiliaciones','AfiliacionesController@index')->name('afiliaciones');
Route::post('/registrarAfiliaciones','AfiliacionesController@store')->name('afiliaciones.store');
Route::post('/borrarAfiliaciones','AfiliacionesController@destroy')->name('afiliaciones.delete');
Route::post('/actualizarAfiliaciones','AfiliacionesController@update')->name('afiliaciones.update');

////CRUD Pagos

Route::get('/pagos','PagosController@index')->name('pagos');
Route::post('/registrarPagos','PagosController@store')->name('pagos.store');
Route::post('/borrarPagos','PagosController@destroy')->name('pagos.delete');
Route::post('/actualizarPagos','PagosController@update')->name('pagos.update');

////Reportes

Route::get('/reportes','ReportesController@index')->name('reportes');
Route::get('/reporteEstado','ReportesController@reporteEstado')->name('reporteEstado');

Route::get('/reporteEstado.pdf','ReportesController@reporteEstadoPdf')->name('reporteEstado.pdf');