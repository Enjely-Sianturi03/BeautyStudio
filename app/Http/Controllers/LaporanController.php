<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $from = $request->date('from');
    $to   = $request->date('to');

    // Ambil data + relasi user dan service
    $q = Appointment::with(['user', 'service'])
        ->where('status', 'completed') 
        ->orderBy('jadwal', 'desc');

    // FILTER BULAN (prioritas utama jika ada)
    if ($request->filled('bulan')) {
        try {
            $bulan = \Carbon\Carbon::parse($request->bulan);
            $q->whereYear('jadwal', $bulan->year)
              ->whereMonth('jadwal', $bulan->month);
        } catch (\Exception $e) {
            // Jika format bulan salah, abaikan filter
        }
    } else {
        // Jika tidak ada filter bulan, gunakan filter from/to (cara lama)
        if ($from) {
            $q->whereDate('jadwal', '>=', $from);
        }

        if ($to) {
            $q->whereDate('jadwal', '<=', $to);
        }
    }

    // Pagination
    $data = $q->paginate(15);

    $data->getCollection()->transform(function ($appointment) {
        // Ambil transaksi terbaru berdasarkan user + service
        $transaksi = \App\Models\Transaksi::where('user_id', $appointment->user_id)
            ->where('service_id', $appointment->service_id)
            ->latest('id')
            ->first();

        $appointment->payment_method = $transaksi?->payment_method;
        $appointment->payment_proof  = $transaksi?->payment_proof;

        return $appointment;
    });

    // Hitung total dari harga layanan
    // PERBAIKAN: hitung dari semua data yang sesuai filter, bukan hanya halaman saat ini
    $totalQuery = Appointment::with('service')
        ->where('status', 'completed');

    if ($request->filled('bulan')) {
        try {
            $bulan = \Carbon\Carbon::parse($request->bulan);
            $totalQuery->whereYear('jadwal', $bulan->year)
                       ->whereMonth('jadwal', $bulan->month);
        } catch (\Exception $e) {
            // Abaikan jika error
        }
    } else {
        if ($from) {
            $totalQuery->whereDate('jadwal', '>=', $from);
        }
        if ($to) {
            $totalQuery->whereDate('jadwal', '<=', $to);
        }
    }

    $total = $totalQuery->get()->sum(fn($item) => $item->service->harga ?? 0);

    return view('admin.laporan.index', compact('data', 'from', 'to', 'total'));
}


    public function exportCsv(Request $request): StreamedResponse
    {
        $from = $request->date('from');
        $to   = $request->date('to');

        $q = Appointment::with(['user', 'service'])
            ->where('status', 'completed')
            ->orderBy('jadwal', 'asc');

        if ($from) {
            $q->whereDate('jadwal', '>=', $from);
        }

        if ($to) {
            $q->whereDate('jadwal', '<=', $to);
        }

        $filename = 'laporan-appointment-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($q) {
            $out = fopen('php://output', 'w');

            // Header CSV
            fputcsv($out, [
                'Tanggal',
                'Pelanggan',
                'Metode',
                'Total (Rp)'
            ]);

            $q->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $t) {
                    fputcsv($out, [
                        $t->appointment_date,
                        $t->user->name ?? '-',
                        strtoupper($t->payment_method ?? '-'),
                        $t->service->harga ?? 0, // ambil dari tabel services
                    ]);
                }
            });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv'
        ]);
    }
}
