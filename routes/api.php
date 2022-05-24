<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StatusUserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::resource('/user', App\Http\Controllers\Api\UserController::class)->only('index', 'store', 'show', 'update', 'destroy')->middleware('role:admin');
Route::resource('/product', App\Http\Controllers\Api\ProductController::class)->only('index', 'store', 'show', 'update', 'destroy')->middleware('role:admin');
Route::get('/order', [App\Http\Controllers\Api\OrderController::class,'index']);
Route::get('/order_detail/{id}', [App\Http\Controllers\Api\OrderDetailController::class,'show']);
Route::get('/products/export/', [App\Http\Controllers\Api\ProductController::class,'export']);
Route::post('/product/import/', [App\Http\Controllers\Api\ProductController::class,'import']);
