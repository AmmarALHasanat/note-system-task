<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;

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
Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    });



Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class,'logout']);
        Route::prefix('/notes')->group(function () {
            Route::get('/', [NoteController::class, 'index']);
            Route::post('/create', [NoteController::class, 'store']);
            Route::get('/{id}', [NoteController::class, 'show']);
            Route::put('/{id}/edit', [NoteController::class, 'update']);
            Route::delete('/{id}/delete', [NoteController::class, 'destroy']);
        });
    });
});
