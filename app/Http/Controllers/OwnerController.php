<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;

class OwnerController extends Controller
{
    public function dashboard()
    {
        // Total Pelanggan
        $totalCustomers = User::where('role', 'customer')->count();

        // Total Layanan
        $totalServices = Service::count();

        // Total Pendapatan (ambil dari tabel services melalui appointment)
        $totalRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                        ->sum('services.harga');

        // Data Semua Layanan
        $services = Service::all();

        // Data Pelanggan
        $customers = User::where('role', 'customer')->get();

        // Data Riwayat Transaksi
        $transactions = Appointment::with(['user','service'])
                        ->orderBy('appointment_date', 'desc')
                        ->take(10)
                        ->get();

        // Pendapatan Mingguan
        // DAYOFWEEK(): 1 = Minggu, 2 = Senin, ... , 7 = Sabtu
        $weeklyRevenue = Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                        ->selectRaw('DAYOFWEEK(appointment_date) as day, SUM(services.harga) as total')
                        ->groupBy('day')
                        ->pluck('total', 'day')
                        ->toArray();

        return view('owner.dashboard', compact(
            'totalCustomers',
            'totalServices',
            'totalRevenue',
            'transactions',
            'services',
            'customers',
            'weeklyRevenue'
        ));
    }


    public function exportTransactionsPdf()
    {
        $transactions = Appointment::with(['user','service'])
                        ->orderBy('appointment_date', 'desc')
                        ->get();

        $pdf = Pdf::loadView('owner.transactions_pdf', compact('transactions'));

        return $pdf->stream('riwayat-transaksi.pdf');
    }
}
