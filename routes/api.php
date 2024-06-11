<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterCompanyEvent;
use App\Http\Controllers\AttendanceRecordController;
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

Route::prefix('participante')->group(function () {
    Route::get('/', [AttendanceRecordController::class, 'index']);
    Route::post('/', [RegisterCompanyEvent::class, 'store']);
    Route::get('/{id}', [RegisterCompanyEvent::class, 'show']);
    Route::get('/buscar/{qr_code}', [AttendanceRecordController::class, 'asistencia']);
    Route::get('/encontrar/{qr_code}', [RegisterCompanyEvent::class, 'encontrarEmpresa']);
    Route::get('/all', [UserController::class, 'list']);
});
