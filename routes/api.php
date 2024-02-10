<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

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
Route::get('/v1/messages', [MessageController::class, 'index']);

Route::prefix('v1')->middleware('auth:sanctum')->group( function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('message/{message}', [MessageController::class, 'edit']);
    Route::post('message', [MessageController::class, 'store']);
    Route::patch('message/{message}', [MessageController::class, 'update']);
    Route::delete('message/{message}', [MessageController::class, 'destroy']);

    Route::prefix('/admin')->group( function() {
        Route::get('roles', [RoleController::class, 'index']);
        Route::get('role/{role}', [RoleController::class, 'edit']);
        Route::post('role', [RoleController::class, 'store']);
        Route::patch('role/{role}', [RoleController::class, 'update']);
        Route::delete('role/{role}', [RoleController::class, 'destroy']);
    });
});
