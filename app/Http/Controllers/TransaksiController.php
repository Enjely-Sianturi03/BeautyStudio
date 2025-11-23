<?php 

namespace App\Http\Controllers;

use App\Models\{Transaksi, TransaksiItem, Pelanggan, Jadwal, Layanan};
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Halaman Index Transaksi
     */
    public function index()
    {
        // Data transaksi + pelanggan (pagination)
        $data = Transaksi::with('pelanggan')
            ->latest()
            ->paginate(10);

        // Dropdown pelanggan
        $pelanggans = Pelanggan::orderBy('nama')->get();

        // Dropdown layanan
        $layanans = Layanan::orderBy('nama')->get();

        // Data jadwal yang masih aktif
        $jadwals = Jadwal::with(['pelanggan', 'layanan'])
            ->where('status', 'dijadwalkan')
            ->orderBy('mulai_at', 'DESC')
            ->get();

        // FIX PAGINATION ERROR → gunakan paginate()
        $appointments = Appointment::with(['service', 'stylist', 'user'])
            ->orderBy('appointment_date', 'DESC')
            ->paginate(10); // ← WAJIB jika ingin memakai links()

        return view('admin.transaksi.index', compact(
            'data',
            'pelanggans',
            'layanans',
            'jadwals',
            'appointments'
        ));
    }


    /**
     * Simpan Transaksi
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'pelanggan_id'        => 'required|exists:pelanggans,id',
            'jadwal_id'           => 'nullable|exists:jadwals,id',
            'metode'              => 'required|in:cash,qris,transfer',
            'items'               => 'required|array|min:1',
            'items.*.layanan_id'  => 'required|exists:layanans,id',
            'items.*.qty'         => 'required|integer|min:1'
        ]);

        $transaksi = null;

        DB::transaction(function () use ($val, &$transaksi) {

            // Buat transaksi utama
            $transaksi = Transaksi::create([
                'pelanggan_id' => $val['pelanggan_id'],
                'jadwal_id'    => $val['jadwal_id'] ?? null,
                'total'        => 0,
                'metode'       => $val['metode'],
                'status'       => 'paid',
                'dibayar_at'   => now(),
            ]);

            // Simpan item layanan
            foreach ($val['items'] as $item) {
                $layanan = Layanan::find($item['layanan_id']);

                TransaksiItem::create([
                    'transaksi_id'  => $transaksi->id,
                    'layanan_id'    => $layanan->id,
                    'qty'           => $item['qty'],
                    'harga_satuan'  => $layanan->harga,
                    'subtotal'      => $layanan->harga * $item['qty']
                ]);
            }

            // Update total final
            $transaksi->refreshTotal();
        });

        return back()->with('ok', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $transaksi = Appointment::with(['user', 'service'])->findOrFail($id);

        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function confirm($id)
    {
        $t = Appointment::findOrFail($id);
        $t->status = 'confirmed';
        $t->save();

        return back()->with('ok', 'Transaksi berhasil dikonfirmasi!');
    }

    public function cancel($id)
    {
        $t = Appointment::findOrFail($id);
        $t->status = 'cancelled';
        $t->save();

        return back()->with('ok', 'Transaksi berhasil dibatalkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled'
        ]);

        $transaksi = Appointment::findOrFail($id);

        $transaksi->status = $request->status;
        $transaksi->save();

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('ok', 'Status transaksi berhasil diubah menjadi ' . strtoupper($request->status));
    }

}
