<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

/* Admin routes */
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth','admin'])
    ->group(base_path('routes/admin/web.php'));

Route::get('/', function () {
    return view('auth/login');
});




//rutas para la verificación del email
Route::get('/home', function () {
    return view('product');
})->middleware('auth','verified')->name('home');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware('verified');

Auth::routes(['verify' => true]);