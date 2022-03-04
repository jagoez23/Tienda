<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::get("prueba",function(){return"hola";});

Route::get('/',[AdminController::class, 'index'])
->name('admin');

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/