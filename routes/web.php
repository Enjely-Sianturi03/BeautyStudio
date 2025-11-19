<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Reviews (Public Submit)
|--------------------------------------------------------------------------
*/
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
Route::get('/tips/{id}', [TipController::class, 'show'])->name('tips.show');

Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Route::get('/home', function () {
    //     return view('customer.dashboard');
    // })->name('customer.dashboard');

    // Appointments
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Employee & Owner
|--------------------------------------------------------------------------
*/
Route::get('/pegawai', [EmployeeController::class, 'index'])
    ->middleware('auth')
    ->name('employee.dashboard');

Route::post('/pegawai/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
    ->middleware('auth')
    ->name('employee.appointment.complete');

Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');

/*
|--------------------------------------------------------------------------
| Admin Review Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
        Route::post('/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
            ->name('appointment.complete');
        Route::get('/jadwal', [EmployeeController::class, 'schedule'])->name('jadwal');
        Route::get('/riwayat', [EmployeeController::class, 'history'])->name('riwayat');
        Route::post('/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
            ->name('appointment.complete');
    });

    // Admin menyetujui review
    Route::post('/admin/reviews/{id}/approve', [ReviewController::class, 'approve'])
        ->name('admin.reviews.approve');

    // Admin menghapus review
    Route::delete('/admin/reviews/{id}', [ReviewController::class, 'destroy'])
        ->name('admin.reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Contact Page
|--------------------------------------------------------------------------
*/
Route::get('/contact', function () {
    return view('contacts.contact');
})->name('contact');

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
