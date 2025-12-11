<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\TipsArtikelController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('services', ServiceController::class)->only(['index', 'show']);
Route::get('/tips', [TipController::class, 'index'])->name('tips.index');


Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/contact', fn() => view('contacts.contact'))->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

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
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('appointments', AppointmentController::class)
        ->only(['index', 'create', 'store', 'show']);

    Route::post('/appointments/{appointment}/cancel', 
        [AppointmentController::class, 'cancel']
    )->name('appointments.cancel');

    Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact')
    ->middleware('auth');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /* DASHBOARD */
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminController::class, 'index']);

        /*
        |--------------------------------------------------------------------------
        | LAYANAN MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::get('/layanan', [AdminController::class, 'layananIndex'])->name('layanan.index');
        Route::post('/layanan', [AdminController::class, 'layananStore'])->name('layanan.store');
        Route::delete('/layanan/{service}', [AdminController::class, 'layananDestroy'])->name('layanan.destroy');
        Route::post('/layanan/{service}/toggle', [AdminController::class, 'layananToggleStatus'])->name('layanan.toggle');

        /*
        |--------------------------------------------------------------------------
        | PELANGGAN MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::get('/pelanggan', [AdminController::class, 'pelangganIndex'])->name('pelanggan.index');
        Route::post('/pelanggan', [AdminController::class, 'pelangganStore'])->name('pelanggan.store');
        Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])
            ->name('pelanggan.update');

        Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])
            ->name('pelanggan.destroy');


        /*
        |--------------------------------------------------------------------------
        | JADWAL MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
        // Route::post('/jadwal/{id}/staff', [JadwalController::class, 'assignStaff'])->name('jadwal.assignStaff');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::post('/transaksi/manual/store', 
            [TransaksiController::class, 'storeManual']
        )->name('transaksi.store.manual');


        // LIST, SHOW, STORE
        Route::resource('transaksi', TransaksiController::class)
            ->only(['index', 'store', 'show']);
        Route::resource('appointments', AppointmentController::class)
        ->except(['create', 'store', 'show']);


        // CONFIRM
        Route::post('/transaksi/{id}/confirm', 
            [TransaksiController::class, 'confirm']
        )->name('transaksi.confirm');

        // CANCEL
        Route::post('/transaksi/{id}/cancel', 
            [TransaksiController::class, 'cancel']
        )->name('transaksi.cancel');

        // Create From Appointment
        Route::get('/transaksi/create/from-appointment/{appointment}', 
            [TransaksiController::class, 'createFromAppointment']
        )->name('transaksi.createFromAppointment');


        /*
        |--------------------------------------------------------------------------
        | ADMIN APPOINTMENTS
        |--------------------------------------------------------------------------
        */
        Route::resource('appointments', AppointmentController::class)
            ->except(['create', 'store', 'show']);

        /*
        |--------------------------------------------------------------------------
        | REVIEW MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        /* --------------------------------------------------
        |   TIPS & ARTIKEL MANAGEMENT
        -------------------------------------------------- */
        Route::resource('tipsartikel', TipsArtikelController::class);

        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export/csv', [LaporanController::class, 'exportCsv'])->name('laporan.export.csv');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

        /*
        |--------------------------------------------------------------------------
        | USERS & REPORTS
        |--------------------------------------------------------------------------
        */
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

        Route::get('/riwayat', [AdminController::class, 'showActivityLogs'])
        ->name('riwayat.index');
    });

/*
|--------------------------------------------------------------------------
| PEGAWAI ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {

        Route::get('/', [EmployeeController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [EmployeeController::class, 'index']);

        Route::post('/appointments/{id}/complete', 
            [EmployeeController::class, 'completeAppointment']
        )->name('appointment.complete');

        Route::get('/jadwal', [EmployeeController::class, 'schedule'])->name('jadwal');
        Route::get('/riwayat', [EmployeeController::class, 'history'])->name('riwayat');
        Route::get('/customers', [EmployeeController::class, 'customers'])->name('employee.customers');
    });

// /*
// |-------------------------------------------------------------------------- 
// | KARYAWAN ROUTES
// |-------------------------------------------------------------------------- 
// */

// Route::middleware(['auth'])->prefix('pegawai')->name('employee.')->group(function () {
//     // dashboard
//     Route::get('/', [EmployeeController::class, 'index'])->name('dashboard');

//     // list pelanggan (halaman index)
//     Route::get('/customers', [EmployeeController::class, 'customers'])->name('customers');

//     // riwayat pelanggan (terima param identifier name/id)
//     Route::get('/customers/{customer}/history', [EmployeeController::class, 'customerHistory'])->name('customer.history');

//     // mulai & selesaikan appointment
//     Route::post('/appointments/{id}/start', [AppointmentController::class, 'start'])->name('appointment.start');
//     Route::post('/appointments/{id}/complete', [AppointmentController::class, 'complete'])->name('appointment.complete');

//     // request restock
//     Route::post('/products/request-restock', [ProductController::class, 'requestRestock'])->name('request.restock');

//     // products & reports
//     Route::get('/products', [ProductController::class, 'index'])->name('products');
//     Route::get('/reports', [EmployeeController::class, 'reports'])->name('reports');
// });

/*
|--------------------------------------------------------------------------
| OWNER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [OwnerController::class, 'dashboard']);

        Route::get('/transactions/pdf', 
            [OwnerController::class, 'exportTransactionsPdf']
        )->name('transactions.pdf');
    });
