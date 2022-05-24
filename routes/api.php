<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StatusUserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas apirestuser
Route::post('register', [App\Http\Controllers\Api\UserApiController::class,'register']);
Route::post('login', [App\Http\Controllers\Api\UserApiController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [App\Http\Controllers\Api\UserApiController::class, 'userProfile']);
    Route::get('logout', [App\Http\Controllers\Api\UserApiController::class, 'logout']);
});

//rutas apirestproduct
Route::get('products', [App\Http\Controllers\Api\ProductApiController::class,'index']);
Route::get('products/{id}/show', [App\Http\Controllers\Api\ProductApiController::class,'show']);
Route::put('products/{id}/update', [App\Http\Controllers\Api\ProductApiController::class,'update']);
//Route::post('products/{id}/update', [App\Http\Controllers\Api\ProductApiController::class,'update']);
Route::post('products/add', [App\Http\Controllers\Api\ProductApiController::class,'store']);
Route::delete('products/{id}/delete', [App\Http\Controllers\Api\ProductApiController::class,'destroy']);


Route::resource('/user', App\Http\Controllers\Api\UserController::class)->only('index', 'store', 'show', 'update', 'destroy')->middleware('role:admin');
Route::resource('/product', App\Http\Controllers\Api\ProductController::class)->only('index', 'store', 'show', 'update', 'destroy')->middleware('role:admin');
Route::get('/order', [App\Http\Controllers\Api\OrderController::class,'index']);
Route::get('/order_detail/{id}', [App\Http\Controllers\Api\OrderDetailController::class,'show']);
Route::get('/products/export/', [App\Http\Controllers\Api\ProductController::class,'export']);
Route::post('/product/import/', [App\Http\Controllers\Api\ProductController::class,'import']);
