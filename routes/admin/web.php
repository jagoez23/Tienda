<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::get("prueba", function () {
    return"hola";
});

Route::get('/', [AdminController::class, 'index'])
->name('admin')->middleware('role:admin');

Route::get('/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
Route::get('/product', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product.index');
