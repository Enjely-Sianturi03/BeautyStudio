<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Digunakan sebagai Model Pelanggan (role='customer')
use App\Models\Service;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf; 

class OwnerController extends Controller
{
    /**
     * Menampilkan dashboard owner dengan data yang diambil dari database.
     * Data yang diambil: Statistik Summary, Daftar Layanan, Daftar Pelanggan, dan Transaksi Terbaru.
     */
    public function dashboard()
    {
        // 1. Hitung Statistik (untuk Cards Summary)
        // Menghitung jumlah total pelanggan (asumsi role 'customer' di Model User)
        $totalCustomers = User::where('role', 'customer')->count();
        // Menghitung jumlah total layanan yang tersedia
        $totalServices = Service::count();
        // Menghitung total pendapatan dari semua transaksi
        $totalRevenue = Transaction::sum('total');

        // 2. Data Layanan (DIPERLUKAN di dashboard)
        // Mengambil semua data layanan
        $services = Service::all();

        // 3. Data Pelanggan (DIPERLUKAN di dashboard)
        // Mengambil semua user yang berperan sebagai pelanggan
        $customers = User::where('role', 'customer')->get();

        // 4. Data Transaksi Terbaru (untuk Tabel Riwayat Transaksi di Dashboard)
        // Mengambil 10 transaksi terbaru, menyertakan data customer dan service terkait
        $transactions = Transaction::with(['customer', 'service'])
                            ->latest()
                            ->take(10) 
                            ->get();

        // Kirim semua data yang sudah diambil ke view owner.dashboard
        return view('owner.dashboard', compact(
            'totalCustomers',
            'totalServices',
            'totalRevenue',
            'transactions',
            'services',   
            'customers'
        ));
    }

    /**
     * Export Riwayat Transaksi ke PDF.
     */
    public function exportTransactionsPdf()
    {
        // Mengambil semua transaksi dengan relasi customer dan service untuk laporan PDF
        $transactions = Transaction::with(['customer','service'])->get();

        // Membuat PDF dari view 'owner.transactions_pdf'
        $pdf = Pdf::loadView('owner.transactions_pdf', compact('transactions'));
        
        // Mengalirkan (stream) PDF ke browser untuk diunduh
        return $pdf->stream('riwayat-transaksi.pdf');
    }
}