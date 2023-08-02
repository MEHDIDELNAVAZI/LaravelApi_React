<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\UserController;


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

Route::post('/login', [AuthController::class, 'login']);
Route::get('/getusers', [AuthController::class, 'getusers']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->delete('/users/{id}',[UserController::class, 'destroy']);
Route::middleware('auth:sanctum')->post('/update/{id}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->get('/getuserdata/{id}', [UserController::class, 'getuserdata']);
Route::middleware('auth:sanctum')->get('/update/{id}', [UserController::class, 'update']);
