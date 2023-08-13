<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PcController;
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

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:sanctum')->as('auth.')->group(function () {
    Route::post('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/issue-token', [AuthController::class, 'issueToken'])->name('issue-token');
});

Route::post('/ping', [PcController::class, 'ping'])->name('ping')->middleware('auth:sanctum');
