<?php 

namespace App\Http\Controllers;

use App\Models\{
    Transaksi,
    TransaksiItem,
    Service
};
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil user role customer
        $users = User::where('role', 'customer')
            ->orderBy('name')
            ->get();

        // Ambil layanan dari table services
        $layanans = Service::orderBy('nama')->get();

        // Jadwal (jika masih dibutuhkan)
        // $jadwals = Jadwal::with(['user', 'service'])
        //     ->where('status', 'dijadwalkan')
        //     ->orderBy('mulai_at', 'DESC')
        //     ->get();

        // Ambil appointments
        $appointments = Appointment::with(['service','stylist','user'])
            ->orderBy('id','DESC')
            ->paginate(10);

        // Ambil semua transaksi
        $transaksi = Transaksi::all()->keyBy(function($t){
            return $t->user_id.'_'.$t->service_id; // key unik: user + service
        });

        return view('admin.transaksi.index', compact(
            'appointments', 'users', 'layanans', 'transaksi'
        ));
    }

    public function store(Request $request)
    {
        $val = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'jadwal_id'          => 'nullable|exists:jadwals,id',
            'metode'             => 'required|in:cash,qris,transfer',

            'items'              => 'required|array|min:1',
            'items.*.layanan_id' => 'required|exists:services,id',
            'items.*.qty'        => 'required|integer|min:1'
        ]);

        $transaksi = null;

        DB::transaction(function () use ($val, &$transaksi) {

            $transaksi = Transaksi::create([
                'user_id'    => $val['user_id'],
                'jadwal_id'  => $val['jadwal_id'] ?? null,
                'total'      => 0,
                'metode'     => $val['metode'],
                'status'     => 'paid',
                'dibayar_at' => now(),
            ]);

            foreach ($val['items'] as $item) {
                $layanan = Service::find($item['layanan_id']);

                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'service_id'   => $layanan->id,
                    'qty'          => $item['qty'],
                    'harga_satuan' => $layanan->harga,
                    'subtotal'     => $layanan->harga * $item['qty']
                ]);
            }

            $transaksi->refreshTotal();
        });

        return back()->with('ok', 'Transaksi berhasil disimpan!');
    }

public function show($id)
{
    $appointment = Appointment::with(['user', 'service'])->findOrFail($id);

    // Ambil transaksi terbaru dari user + service yang sama
    $transaksi = Transaksi::where('user_id', $appointment->user_id)
        ->where('service_id', $appointment->service_id)
        ->latest('id')
        ->first();

    return view('admin.transaksi.show', [
        'appointment' => $appointment,
        'transaksi'   => $transaksi
    ]);
}

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:confirmed,cancelled']);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => $request->status]);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('ok', 'Status transaksi berhasil diubah!');
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'payment_method'   => 'required|in:cash,qris,transfer',
        ]);

        // Ambil user
        $user = User::find($request->user_id);

        // Ambil service
        $service = Service::findOrFail($request->service_id);

        DB::beginTransaction();
        try {
            // ✅ SIMPAN APPOINTMENT - HANYA kolom yang PASTI ADA
            $appointment = Appointment::create([
                'user_id'       => $user->id,
                'service_id'    => $service->id,
                'stylist_id'    => null,
                'jadwal'        => $request->appointment_date,
                'jam_mulai'     => $request->appointment_time,
                'status'        => 'completed',
                // 🔧 HAPUS 'notes' - kolom ini tidak ada di tabel
            ]);

            // ✅ SIMPAN DATA PEMBAYARAN ke tabel TRANSAKSI
            $transaksi = Transaksi::create([
                'user_id'       => $user->id,
                'service_id'    => $service->id,
                'appointment_id'=> $appointment->id, // Link ke appointment
                'date'          => $request->appointment_date,
                'total'         => $service->harga,
                'payment_method'=> $request->payment_method,
                'status'        => 'paid',
                'paid_at'       => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('ok', 'Transaksi manual berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ubah status appointment menjadi confirmed
        $appointment->update([
            'status' => 'confirmed'
        ]);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi / Appointment berhasil dikonfirmasi!');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ubah status appointment menjadi cancelled
        $appointment->update([
            'status' => 'cancelled'
        ]);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi / Appointment berhasil dibatalkan!');
    }


}
