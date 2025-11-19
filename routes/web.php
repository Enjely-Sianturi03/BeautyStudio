<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController; // FIXED: Using the Admin namespace
use App\Http\Controllers\LaporanController;   // Keeping root LaporanController for now
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Services (Public)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Tips (Public)
Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
Route::get('/tips/{id}', [TipController::class, 'show'])->name('tips.show');

// Booking (Public)
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Contact (Public)
Route::get('/contact', function () {
    return view('contacts.contact');
})->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Reviews (Public Submit)
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Routes (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
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
| ADMIN ROUTES (Role: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Dashboard
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminController::class, 'index']); // Alias
        
        // Layanan Management (Service)
        Route::get('/layanan', [AdminController::class, 'layananIndex'])->name('layanan.index');
        Route::post('/layanan', [AdminController::class, 'layananStore'])->name('layanan.store');
        Route::delete('/layanan/{service}', [AdminController::class, 'layananDestroy'])->name('layanan.destroy');
        Route::post('/layanan/{service}/toggle', [AdminController::class, 'layananToggleStatus'])->name('layanan.toggle');
        
        // Pelanggan Management
        Route::get('/pelanggan', [AdminController::class, 'pelangganIndex'])->name('pelanggan.index');
        Route::post('/pelanggan', [AdminController::class, 'pelangganStore'])->name('pelanggan.store');
        Route::put('/pelanggan/{user}', [AdminController::class, 'pelangganUpdate'])->name('pelanggan.update'); // Menggunakan {user} untuk Route Model Binding
        Route::delete('/pelanggan/{user}', [AdminController::class, 'pelangganDestroy'])->name('pelanggan.destroy');
        
        // Jadwal Management
        Route::resource('jadwal', JadwalController::class)->only(['index','store','update','destroy']);
        
        // Transaksi Management (FIXED: Using Admin\TransaksiController)
        Route::resource('transaksi', TransaksiController::class)->only(['index','store']);
        // NEW: Route untuk Update Status Transaksi
        Route::put('/transaksi/{transaksi}/update-status', [TransaksiController::class, 'updateStatus'])
             ->name('transaksi.update-status');
        
        // Appointments Management
        Route::resource('appointments', AppointmentController::class)->except(['create', 'store', 'show']);
        
        // Review Management
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index'); // Added index route for review admin panel
        Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        
        // Laporan (RESTORED: Using root LaporanController)
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'exportCsv'])->name('laporan.export');
        
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        
        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });

/*
|--------------------------------------------------------------------------
| EMPLOYEE ROUTES (Role: pegawai)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {
        
        // Dashboard
        Route::get('/', [EmployeeController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [EmployeeController::class, 'index']); // Alias
        
        // Complete Appointment
        Route::post('/layanan/{id}/selesai', [EmployeeController::class, 'completeAppointment'])
            ->name('appointment.complete');
        
        // Schedule
        Route::get('/jadwal', [EmployeeController::class, 'schedule'])->name('jadwal');
        
        // History
        Route::get('/riwayat', [EmployeeController::class, 'history'])->name('riwayat');
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
        
        // Dashboard
        Route::get('/', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [OwnerController::class, 'dashboard']); // Alias
        
        // Export Transactions PDF
        Route::get('/transactions/pdf', [OwnerController::class, 'exportTransactionsPdf'])
            ->name('transactions.pdf');
    });