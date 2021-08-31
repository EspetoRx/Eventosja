<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\EventosController;
use App\Http\Controllers\API\ConvidadosController;
use App\Http\Controllers\API\ConvidadosEventosController;

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

Route::resource('/eventos', EventosController::class);
Route::resource('/convidados', ConvidadosController::class);
Route::resource('/convidados_eventos', ConvidadosEventosController::class);
