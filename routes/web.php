<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/home', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

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

// Tambahan route untuk cetak PDF transaksi
Route::get('/owner/transactions/pdf', [OwnerController::class, 'exportTransactionsPdf'])
     ->name('owner.transactions.pdf');
/*
|--------------------------------------------------------------------------
| Admin Review Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Admin melihat semua review
    Route::get('/admin/reviews', [ReviewController::class, 'index'])
        ->name('admin.reviews.index');

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
