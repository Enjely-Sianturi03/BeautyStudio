<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// ====================
//  AUTHENTICATION ROUTES
// ====================

// Tampilkan form login & proses login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Tampilkan form register & proses register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Proses logout (gunakan POST agar aman)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================
//  PUBLIC ROUTES
// ====================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// ====================
//  AUTHENTICATED USER ROUTES
// ====================

Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
});

// ====================
//  ADMIN ROUTES
// ====================

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD Data Service (layanan salon)
    Route::resource('/services', ServiceController::class)->except(['index', 'show']);

    // CRUD Appointments (reservasi pelanggan)
    Route::resource('/appointments', AppointmentController::class)->except(['create', 'store', 'show']);

    // CRUD Gallery (foto-foto salon)
    Route::resource('/gallery', GalleryController::class)->except(['index']);

    // Tambahan route opsional
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

require __DIR__.'/auth.php';
