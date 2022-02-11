<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('personas/new-register', 'App\Http\Controllers\personas\PersonaController@saveNewRegister');
Route::post('registro-entrega/registro', 'App\Http\Controllers\entregas\RegistroEntregaController@llenadoDatosRegistrosEntregas');
Route::post('entrega-productos/registro', 'App\Http\Controllers\entregas\RegistroEntregaController@llenadoDatosEntregaProductos');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
