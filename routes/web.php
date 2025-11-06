<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
// use App\Http\Controllers\GalleryController;  <-- dikasih // biar nonaktif
// use App\Http\Controllers\AuthController;     <-- dikasih // biar nonaktif
use Illuminate\Support\Facades\Route;

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  
// Route::post('/login', [AuthController::class, 'login']);                       


// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

//Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\OwnerController;

Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');

