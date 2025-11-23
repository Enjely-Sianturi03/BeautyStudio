<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from');
        $to   = $request->date('to');

        // Ambil data + relasi user dan service
        $q = Appointment::with(['user', 'service'])
            ->orderBy('appointment_date', 'desc');

        if ($from) {
            $q->whereDate('appointment_date', '>=', $from);
        }

        if ($to) {
            $q->whereDate('appointment_date', '<=', $to);
        }

        // Pagination
        $data = $q->paginate(15);

        // Hitung total dari harga layanan
        $total = (clone $q)->get()->sum(fn ($item) => $item->service->harga ?? 0);

        return view('admin.laporan.index', compact('data', 'from', 'to', 'total'));
    }


    public function exportCsv(Request $request): StreamedResponse
    {
        $from = $request->date('from');
        $to   = $request->date('to');

        $q = Appointment::with(['user', 'service'])
            ->orderBy('appointment_date', 'asc');

        if ($from) {
            $q->whereDate('appointment_date', '>=', $from);
        }

        if ($to) {
            $q->whereDate('appointment_date', '<=', $to);
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
