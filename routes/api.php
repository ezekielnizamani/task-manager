<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\TasksController;

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
// public routes

Route::get("/unauthenticated", function () {
    return response()->json(['message' => 'Unauthenticated'], 401);
})->name("unauthenticated");

Route::group(['prefix' => 'v1'], function () {
    Route::post('/signup', [AuthController::class, 'signUp']);
    Route::post('/login', [AuthController::class, 'login']);

});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/tasks', [TasksController::class, 'index']);
    Route::get('/tasks/{id}', [TasksController::class, 'show']);
    Route::post('/task/create', [TasksController::class, 'store']);
});