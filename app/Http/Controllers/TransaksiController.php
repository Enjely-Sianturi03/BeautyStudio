<?php

namespace App\Http\Controllers;

use App\Models\{Transaksi, TransaksiItem, Pelanggan, Jadwal, Layanan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index() {
        $data = Transaksi::with(['pelanggan','jadwal'])->latest()->paginate(10);
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        $jadwals = Jadwal::where('status','dijadwalkan')->latest('mulai_at')->get();
        return view('admin.transaksi.index', compact('data','pelanggans','layanans','jadwals'));
    }

    // contoh pembuatan transaksi dengan items
    public function store(Request $request) {
        $val = $request->validate([
            'pelanggan_id'=>'required|exists:pelanggans,id',
            'jadwal_id'=>'nullable|exists:jadwals,id',
            'metode'=>'required|in:cash,qris,transfer',
            'items'=>'required|array|min:1', 
            'items.*.layanan_id'=>'required|exists:layanans,id',
            'items.*.qty'=>'required|integer|min:1'
        ]);

        DB::transaction(function() use ($val, &$transaksi) {
            $transaksi = Transaksi::create([
                'pelanggan_id'=>$val['pelanggan_id'],
                'jadwal_id'=>$val['jadwal_id'] ?? null,
                'total'=>0,
                'metode'=>$val['metode'],
                'dibayar_at'=>now()
            ]);

            foreach ($val['items'] as $row) {
                $layanan = Layanan::find($row['layanan_id']);
                $qty = $row['qty'];
                TransaksiItem::create([
                    'transaksi_id'=>$transaksi->id,
                    'layanan_id'=>$layanan->id,
                    'qty'=>$qty,
                    'harga_satuan'=>$layanan->harga,
                    'subtotal'=>$layanan->harga * $qty
                ]);
            }
            $transaksi->refreshTotal();
        });

        return back()->with('ok','Transaksi tersimpan');
    }
}
