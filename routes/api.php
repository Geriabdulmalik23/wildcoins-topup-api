<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products',[ProductController::class,'index']);
Route::get('/product',[ProductController::class,'home']);
Route::get('/product/item',[ProductController::class,'fetchItem']);
Route::get('/order/check',[OrderController::class,'fetchPrice']);
Route::get('/payments',[OrderController::class,'fetchPaymentMethod']);


Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/order/create',[OrderController::class,'createOrder']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
