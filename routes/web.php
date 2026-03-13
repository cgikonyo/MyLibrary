<?php


use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// all book routes should be protected by authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);
});

// optionally serve a simple homepage - could redirect to books
Route::get('/', function () {
    return redirect()->route('books.index');
});



// authentication routes (only available to guests)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// logout should be available to authenticated users
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
