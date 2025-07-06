<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Login route
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

//Product routes
Route::get('/retrieve-products', [App\Http\Controllers\Api\ProductController::class, 'index'])->middleware('auth:sanctum');
Route::post('/create-products', [App\Http\Controllers\Api\ProductController::class, 'store'])->middleware('auth:sanctum');


//Category routes
Route::get('/retrieve-categories', [App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::post('/create-categories', [App\Http\Controllers\Api\CategoryController::class, 'store'])->middleware('auth:sanctum');
