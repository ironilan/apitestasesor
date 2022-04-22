<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', [function () {
    return view('welcome');
}]);


Route::get('asesores', [HomeController::class, 'asesores']);
Route::get('clientes', [HomeController::class, 'clientes']);
Route::get('productos', [HomeController::class, 'productos']);
Route::get('pedidos', [HomeController::class, 'pedidos']);
Route::get('asignar', [HomeController::class, 'asignar']);
