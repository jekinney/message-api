<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    // Public (guest) routes
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/news/articles', [ArticleController::class, 'index']);
    Route::get('/news/article/{slug}', [ArticleController::class, 'show']);

    // Authentication required routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        // User data
        Route::get('/user/messages', [UserController::class, 'messages'])->withTrashed();
        // Message routes for members
        Route::get('message/{message}', [MessageController::class, 'edit'])->middleware('can:update,message');
        Route::post('message', [MessageController::class, 'store']);
        Route::patch('message/{message}', [MessageController::class, 'update']);
        Route::delete('message/{message}', [MessageController::class, 'destroy'])->withTrashed()->middleware('can:delete,message');
        // Admin access only routes
        Route::prefix('admin')->group(function () {
            // Articles
            Route::get('/articles', [AdminArticleController::class, 'index'])->withTrashed();
            Route::get('/article/edit/{article}', [AdminArticleController::class, 'edit'])->withTrashed();
            Route::get('/article/show/{article}', [AdminArticleController::class, 'show'])->withTrashed();
            // Roles
            Route::get('roles', [AdminRoleController::class, 'index']);
            Route::get('role/{role}', [AdminRoleController::class, 'edit']);
            Route::post('role', [AdminRoleController::class, 'store']);
            Route::patch('role/{role}', [AdminRoleController::class, 'update']);
            Route::delete('role/{role}', [AdminRoleController::class, 'destroy']);
        });
    });
});
