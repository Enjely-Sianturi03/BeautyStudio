<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
<<<<<<< HEAD
// use App\Http\Controllers\GalleryController;  <-- dikasih // biar nonaktif
// use App\Http\Controllers\AuthController;     <-- dikasih // biar nonaktif
use Illuminate\Support\Facades\Route;

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  
// Route::post('/login', [AuthController::class, 'login']);                       

=======
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
>>>>>>> 7831b29bf5c26abc5d2b7033d5a5584c173ab7a4

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Layanan (services)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

<<<<<<< HEAD
//Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
=======
// Galeri
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
>>>>>>> 7831b29bf5c26abc5d2b7033d5a5584c173ab7a4

// Booking (form & simpan)
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login, Register, Logout)
|--------------------------------------------------------------------------
*/

// Tampilkan form login & proses login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Tampilkan form register & proses register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Proses logout (gunakan POST agar aman)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Hanya bisa diakses setelah login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard / Home setelah login
    Route::get('/home', function () {
        return view('home');
    })->name('dashboard');

    // Appointments (jadwal pelanggan)
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index'); 
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');

    // Profile (edit data user)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

<<<<<<< HEAD
require __DIR__.'/auth.php';

use App\Http\Controllers\OwnerController;

Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
=======
// ROUTE BARU: Untuk menampilkan dashboard pegawai (GET)
Route::get('/pegawai', [EmployeeController::class, 'index'])
    ->middleware('auth')
    ->name('employee.dashboard'); // Gunakan nama ini jika Anda ingin menavigasi ke sana
    
// ROUTE LAMA: Untuk aksi menyelesaikan layanan (POST)
Route::post('/pegawai/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
    ->middleware('auth')
    ->name('employee.appointment.complete');
>>>>>>> 7831b29bf5c26abc5d2b7033d5a5584c173ab7a4

