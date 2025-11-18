<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request) {
        $from = $request->date('from');
        $to = $request->date('to');
        $q = Transaksi::with('pelanggan')->orderBy('created_at','desc');
        if ($from) $q->whereDate('created_at','>=',$from);
        if ($to)   $q->whereDate('created_at','<=',$to);
        $data = $q->paginate(15);
        $total = (clone $q)->sum('total');
        return view('admin.laporan.index', compact('data','from','to','total'));
    }

    public function exportCsv(Request $request): StreamedResponse {
        $from = $request->date('from');
        $to = $request->date('to');
        $q = Transaksi::with('pelanggan')->orderBy('created_at');
        if ($from) $q->whereDate('created_at','>=',$from);
        if ($to)   $q->whereDate('created_at','<=',$to);

        $filename = 'laporan-transaksi-'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function() use ($q) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Tanggal','Pelanggan','Total (Rp)','Metode']);
            $q->chunk(200, function($rows) use ($out) {
                foreach ($rows as $t) {
                    fputcsv($out, [
                        $t->created_at->format('Y-m-d H:i'),
                        $t->pelanggan->nama ?? '-',
                        $t->total,
                        strtoupper($t->metode)
                    ]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type'=>'text/csv']);
    }
}
