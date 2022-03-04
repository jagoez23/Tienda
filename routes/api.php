<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StatusUserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource(name:'/user', controller:App\Http\Controllers\Api\UserController::class)->only('index','store','show','update','destroy');
Route::resource(name:'/product', controller:App\Http\Controllers\Api\ProductController::class)->only('index','store','show','update','destroy');





