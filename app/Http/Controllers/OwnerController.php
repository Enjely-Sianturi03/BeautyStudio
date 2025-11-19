<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf; // ← tambahan sesuai permintaan

class OwnerController extends Controller
{
    public function dashboard()
    {
        // Data dummy untuk testing
        $totalCustomers = 10;
        $totalServices = 5;
        $totalRevenue = 1500000;

        $transactions = [
            (object)[
                'date' => '2025-11-05',
                'customer' => (object)['name' => 'Dewi'],
                'service' => (object)['name' => 'Hair Spa'],
                'total' => 150000,
            ],
            (object)[
                'date' => '2025-11-04',
                'customer' => (object)['name' => 'Rani'],
                'service' => (object)['name' => 'Manicure'],
                'total' => 80000,
            ],
        ];

        return view('owner.dashboard', compact(
            'totalCustomers',
            'totalServices',
            'totalRevenue',
            'transactions'
        ));
    }

    // ← tambahan sesuai permintaan
    public function exportTransactionsPdf()
    {
        $transactions = Transaction::with(['customer','service'])->get();

        $pdf = Pdf::loadView('owner.transactions_pdf', compact('transactions'));
        return $pdf->stream('riwayat-transaksi.pdf');
    }
}
