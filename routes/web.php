<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController, ServiceController, AppointmentController, GalleryController,
    AuthController, AdminController, BookingController, ProfileController,
    EmployeeController, OwnerController, PelangganController, LayananController,
    JadwalController, TransaksiController, LaporanController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses siapa pun, termasuk yang belum login)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Booking umum (bisa diakses tanpa login)
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Login, Register, Logout)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (Role: customer)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/home', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| PEGAWAI ROUTES (Role: pegawai)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
        Route::post('/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
            ->name('appointment.complete');
    });


/*
|--------------------------------------------------------------------------
| OWNER ROUTES (Role: owner)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'exportCsv'])->name('laporan.export');
    });


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // CRUD Data Master
        Route::resource('services', ServiceController::class)->except(['index', 'show']);
        Route::resource('appointments', AppointmentController::class)->except(['create', 'store', 'show']);
        Route::resource('gallery', GalleryController::class)->except(['index']);
        Route::resource('pelanggan', PelangganController::class)->only(['index','store','update','destroy']);
        Route::resource('layanan', LayananController::class)->only(['index','store','update','destroy']);
        Route::resource('jadwal', JadwalController::class)->only(['index','store','update','destroy']);
        Route::resource('transaksi', TransaksiController::class)->only(['index','store']);

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'exportCsv'])->name('laporan.export');

        // Tambahan Admin
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });
