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
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


////CRUD Clientes

Route::get('/clientes','ClientesController@index')->name('clientes')->middleware('auth');
Route::post('/registrarClientes','ClientesController@store')->name('clientes.store')->middleware('auth');
Route::post('/borrarClientes','ClientesController@destroy')->name('clientes.delete')->middleware('auth');
Route::post('/actualizarClientes','ClientesController@update')->name('clientes.update')->middleware('auth');

////CRUD Servicios

Route::get('/servicios','ServiciosController@index')->name('servicios')->middleware('auth');
Route::post('/registrarServicios','ServiciosController@store')->name('servicios.store')->middleware('auth');
Route::post('/borrarServicios','ServiciosController@destroy')->name('servicios.delete')->middleware('auth');
Route::post('/actualizarServicios','ServiciosController@update')->name('servicios.update')->middleware('auth');

////CRUD Afiliaciones

Route::get('/afiliaciones','AfiliacionesController@index')->name('afiliaciones')->middleware('auth');
Route::post('/registrarAfiliaciones','AfiliacionesController@store')->name('afiliaciones.store')->middleware('auth');
Route::post('/borrarAfiliaciones','AfiliacionesController@destroy')->name('afiliaciones.delete')->middleware('auth');
Route::post('/actualizarAfiliaciones','AfiliacionesController@update')->name('afiliaciones.update')->middleware('auth');

////CRUD Pagos

Route::get('/pagos','PagosController@index')->name('pagos')->middleware('auth');
Route::post('/registrarPagos','PagosController@store')->name('pagos.store')->middleware('auth');
Route::post('/borrarPagos','PagosController@destroy')->name('pagos.delete')->middleware('auth');
Route::post('/actualizarPagos','PagosController@update')->name('pagos.update')->middleware('auth');

//Recibos

Route::get('/recibo.pdf','PagosController@print')->name('recibo.pdf')->middleware('auth');

////Reportes

Route::get('/reportes','ReportesController@index')->name('reportes')->middleware('auth');
Route::get('/reporteEstado','ReportesController@reporteEstado')->name('reporteEstado')->middleware('auth');

Route::get('/reporteEstado.pdf','ReportesController@reporteEstadoPdf')->name('reporteEstado.pdf')->middleware('auth');