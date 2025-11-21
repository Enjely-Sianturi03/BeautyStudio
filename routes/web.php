<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Employee\ProductController;
use App\Http\Controllers\{
    PelangganController, LayananController, JadwalController,
    TransaksiController, LaporanController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Booking
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard / Home setelah login
    Route::get('/home', function () {
        return view('home');
    })->name('dashboard');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Employee
    Route::get('/pegawai', [EmployeeController::class, 'index'])->name('employee.dashboard');
    Route::post('/pegawai/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
        ->name('employee.appointment.complete');

    // Owner Dashboard
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // CRUD Data Service
    Route::resource('services', ServiceController::class)->except(['index', 'show']);
    Route::resource('appointments', AppointmentController::class)->except(['create', 'store', 'show']);
    Route::resource('gallery', GalleryController::class)->except(['index']);

    // Data tambahan admin
    Route::resource('pelanggan', PelangganController::class)->only(['index','store','update','destroy']);
    Route::resource('layanan',   LayananController::class)->only(['index','store','update','destroy']);
    Route::resource('jadwal',    JadwalController::class)->only(['index','store','update','destroy']);
    Route::resource('transaksi', TransaksiController::class)->only(['index','store']);

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [LaporanController::class, 'exportCsv'])->name('laporan.export');

    // Tambahan opsional
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('reports', [AdminController::class, 'reports'])->name('reports');
});

/*
|-------------------------------------------------------------------------- 
| KARYAWAN ROUTES
|-------------------------------------------------------------------------- 
*/

Route::middleware(['auth','role:employee'])->prefix('pegawai')->name('employee.')->group(function () {
    // dashboard
    Route::get('/', [EmployeeController::class, 'index'])->name('dashboard');

    // list pelanggan (halaman index)
    Route::get('/customers', [EmployeeController::class, 'customers'])->name('customers');

    // riwayat pelanggan (terima param identifier name/id)
    Route::get('/customers/{customer}/history', [EmployeeController::class, 'customerHistory'])->name('customer.history');

    // mulai & selesaikan appointment
    Route::post('/appointments/{id}/start', [AppointmentController::class, 'start'])->name('appointment.start');
    Route::post('/appointments/{id}/complete', [AppointmentController::class, 'complete'])->name('appointment.complete');

    // request restock
    Route::post('/products/request-restock', [ProductController::class, 'requestRestock'])->name('request.restock');

    // products & reports
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/reports', [EmployeeController::class, 'reports'])->name('reports');
});
