<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\TagController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/user-verify', [AuthController::class, 'verify']);
    Route::get('/stats', \App\Http\Controllers\Api\V1\StatsController::class);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['middleware' => ['verified-user']], function () {
            Route::apiResource('tags', TagController::class)->except([
                'show'
            ]);
            Route::get('posts/trashed',[PostController::class,'trashed'])->withTrashed();
            Route::post('posts/{post}/restore',[PostController::class,'restore'])->withTrashed();
            Route::apiResource('posts', PostController::class);
        });
    });
});

