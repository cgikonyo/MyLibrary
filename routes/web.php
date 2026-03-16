<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Authenticated routes (books CRUD, search, logout)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
    Route::get('/search', [BookController::class, 'search'])->name('books.search');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Guest routes (login & register)
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Homepage redirect
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('books.index');
    }
    return redirect()->route('login');
});
