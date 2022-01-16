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
	 Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	 Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	 Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	 Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	 Route::get('personas/get-all-registers', 'App\Http\Controllers\personas\PersonaController@getAllRegisterPerson')->name('persona.get-all');
	 Route::post('personas/get-data-all', 'App\Http\Controllers\personas\PersonaController@GetAllRegisterDatatable')->name('personas.get-data-all');
	 Route::post('personas/get-detalle', 'App\Http\Controllers\personas\PersonaController@getDetalleEntrega')->name('personas.detalle');
	 Route::put('personas/update', 'App\Http\Controllers\personas\PersonaController@UpdateEntregaProducto')->name('personas.update');
	 Route::post('personas/filter', 'App\Http\Controllers\personas\PersonaController@personFilter')->name('personas.filter');
	 
	 
	 
});

