<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Service;
use App\Models\Transaksi;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama admin dengan statistik.
     */
    public function index()
    {
        // Statistik Summary
        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::count();
        
        // Menghitung jadwal hari ini (asumsi Model Jadwal ada dan memiliki kolom 'mulai_at')
        $totalSchedulesToday = \App\Models\Appointment::whereDate('jadwal', now()->toDateString())->count();
        
        // Menghitung pendapatan bulan ini
        $revenueThisMonth = \DB::table('transaksi as t')
                            ->join('appointments as a', 't.appointment_id', '=', 'a.id')
                            ->join('services as s', 'a.service_id', '=', 's.id')
                            ->whereMonth('t.created_at', now()->month)
                            ->whereYear('t.created_at', now()->year)
                            ->sum('s.harga');

        // Data Pelanggan Terbaru (5 data)
        $latestCustomers = User::where('role', 'customer')
                             ->latest()
                             ->take(5)
                             ->get();

        // Mengembalikan view admin.dashboard dengan semua data statistik dan daftar pelanggan
        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalServices',
            'totalSchedulesToday',
            'revenueThisMonth',
            'latestCustomers'
        ));
    }


    // ====================================================================
    // 1. KELOLA PELANGGAN (Model User)
    // ====================================================================

    /**
     * Menampilkan daftar pelanggan dengan paginasi.
     */
    public function pelangganIndex()
    {
        // Ambil data pelanggan (role 'customer') dengan 10 item per halaman
        $data = User::whereIn('role', ['customer', 'pegawai'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        
        return view('admin.pelanggan.index', compact('data'));
    }

    /**
     * Menyimpan pelanggan baru (User dengan role 'customer').
     */
    public function pelangganStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Buat User baru sebagai Pelanggan
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Memperbarui data pelanggan (Quick Save).
     */
    public function pelangganUpdate(Request $request, User $pelanggan)
    {
        // Asumsi $pelanggan adalah instance dari User Model
        $request->validate([
            'name' => 'required|string|max:255',
            // Tambahkan validasi untuk field lain yang ingin diupdate
        ]);

        $pelanggan->update([
            'name' => $request->name,
            'telepon' => $request->telepon, // Anda harus mengirim field ini melalui hidden input atau form lain
            'email' => $request->email,     // Anda harus mengirim field ini melalui hidden input atau form lain
            'alamat' => $request->alamat,   // Anda harus mengirim field ini melalui hidden input atau form lain
        ]);

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus pelanggan.
     */
    public function pelangganDestroy(User $pelanggan)
    {
        // Hapus semua transaksi terkait pelanggan ini
        Transaksi::where('customer_id', $pelanggan->id)->delete();
        
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil dihapus.');
    }


    // ====================================================================
    // 2. KELOLA LAYANAN (Model Service)
    // ====================================================================

    /**
     * Menampilkan daftar layanan dengan paginasi.
     */
    public function layananIndex()
    {
        // Ambil data layanan dengan 10 item per halaman
        $data = Service::orderBy('nama', 'asc')->paginate(10);
        
        return view('admin.layanan.index', compact('data'));
    }

    /**
     * Menyimpan layanan baru.
     */
    public function layananStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'durasi_menit' => 'required|integer|min:5',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Menghapus layanan.
     */
    public function layananDestroy(Service $layanan)
    {
        // Hapus semua transaksi terkait layanan ini (jika ada relasi)
        Transaction::where('service_id', $layanan->id)->delete();

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }

    public function jadwalIndex()
    {
        $appointments = Appointment::with(['user', 'service', 'stylist'])->get(); // eager load
        $staff = User::where('role', 'pegawai')->get(); // ambil semua pegawai/staf

        return view('admin.jadwal.index', compact('appointments', 'staff'));
    }
}