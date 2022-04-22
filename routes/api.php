<?php

use App\Http\Controllers\Api\AsesorController;
use App\Http\Controllers\Api\AsignarController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProductoController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//asesores
Route::resource('asesores', AsesorController::class)->names('asesores');


//clientes
Route::resource('clientes', ClienteController::class)->names('clientes');

//productos
Route::resource('productos', ProductoController::class)->names('productos');


//asignar
Route::get('clientes_asignados/{idasesor}', [AsignarController::class, 'clientes_asesor'])->name('mostrar.clientes.asesor');
Route::post('asignar_clientes', [AsignarController::class, 'asignar_clientes'])->name('asignar.clientes.asesor');


//pedidos
Route::resource('pedidos', PedidoController::class)->names('pedidos');