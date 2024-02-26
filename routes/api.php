<?php

use App\Http\Controllers\Api\V1\AuthController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/user-verify', [AuthController::class, 'verify']);
    Route::get('/stats', \App\Http\Controllers\Api\StatsController::class);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['middleware' => ['verified-user']], function () {
            Route::apiResource('tags',\App\Http\Controllers\Api\V1\TagController::class)->except([
                'show'
            ]);
            Route::apiResource('posts',\App\Http\Controllers\Api\V1\PostController::class);
        });
    });
});

