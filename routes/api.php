<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\EmpresasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/empresas', [EmpresasController::class, 'create']);
Route::put('/reservas/{id}', [CalendarioController::class, 'update']);
Route::post('/reservas', [CalendarioController::class, 'create']);
Route::get('/reservas', [CalendarioController::class, 'getReservas']);
Route::get('/empresas', [EmpresasController::class, 'getEmpresas']);