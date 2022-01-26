<?php

use Illuminate\Support\Facades\Auth;
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
	//return view('login');
	return redirect('login');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	 Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	 //Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	 Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	 Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	 Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	 Route::get('personas/get-all-registers', 'App\Http\Controllers\personas\PersonaController@getAllRegisterPerson')->name('persona.get-all');
	 Route::post('personas/get-data-all', 'App\Http\Controllers\personas\PersonaController@GetAllRegisterDatatable')->name('personas.get-data-all');
	 Route::post('personas/get-detalle', 'App\Http\Controllers\personas\PersonaController@getDetalleEntrega')->name('personas.detalle');
	 
	 Route::post('personas/filter', 'App\Http\Controllers\personas\PersonaController@personFilter')->name('personas.filter');
	 //Route::put('personas/update-entrega', 'App\Http\Controllers\personas\PersonaController@updateEntregaProducto')->name('update.entrega');
	 

	 Route::get('productos-entregados/lista-personas', 'App\Http\Controllers\entregas\RegistroEntregaController@listaProductosEntregados')->name('lista.entregados');
	 Route::get('productos-entregados/lista-personas-pendientes', 'App\Http\Controllers\entregas\RegistroEntregaController@listaProductosPendientes')->name('lista.pendientes');
	 Route::post('productos-entregados/get-data-all-entregados', 'App\Http\Controllers\entregas\RegistroEntregaController@GetAllRegisterDatatableEntregados')->name('personas.get-data-all-entregados');
	 Route::post('productos-pendientes/get-data-all-pendientes', 'App\Http\Controllers\entregas\RegistroEntregaController@GetAllRegisterDatatablePendiente')->name('personas.get-data-all-pendientes');
	//entragas controller
	Route::post('entregas/entrega-producto', 'App\Http\Controllers\entregas\RegistroEntregaController@RegistroEntregaProducto')->name('entrega.producto');
	Route::post('entregas/entrega-detalle', 'App\Http\Controllers\entregas\RegistroEntregaController@getDetalleEntregaCompl')->name('detalle.entrega');
	Route::put('entregas/complemento-producto', 'App\Http\Controllers\entregas\RegistroEntregaController@updateEntregaProductoComplemento')->name('update.entrega');
	Route::get('entregas/detalle-pdf/{id_persona}', 'App\Http\Controllers\entregas\RegistroEntregaController@generatePdfDetalleEntrega');
	

	Route::get('personas/export-csv', 'App\Http\Controllers\personas\PersonaController@exporCsv');//->name('personas.export.csv');
});

