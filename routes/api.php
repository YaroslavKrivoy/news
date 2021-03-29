<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/news', [App\Http\Controllers\API\NewsController::class, 'index']);
Route::get('/news/{news}', [App\Http\Controllers\API\NewsController::class, 'show']);
Route::get('/news/category/{id}', [App\Http\Controllers\API\NewsController::class, 'showByCategoryId']);

Route::middleware('auth:api')->group(function () {
    Route::resource('categories', App\Http\Controllers\API\CategoryController::class)->middleware('role:root');
    Route::get('/userinfo', [App\Http\Controllers\API\AuthController::class, 'userInfo']);
    Route::middleware('role:User|root')->group(function () {
        Route::post('/news', [App\Http\Controllers\API\NewsController::class, 'store']);
        Route::patch('/news/{news}', [App\Http\Controllers\API\NewsController::class, 'update']);
        Route::delete('/news/{news}', [App\Http\Controllers\API\NewsController::class, 'destroy']);
    });
});

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

