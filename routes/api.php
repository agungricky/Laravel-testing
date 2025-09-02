<?php

use App\Http\Controllers\JWTController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JWTMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Menggunakan teknik memanggil midleware langsung tanpa alias
Route::prefix('admin')->middleware(JWTMiddleware::class)->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::patch('/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
});

Route::prefix('user')->group(function () {
    Route::post('/register', [JWTController::class, 'register'])->name('user.register');
    Route::post('/login', [JWTController::class, 'login'])->name('user.login');
});
