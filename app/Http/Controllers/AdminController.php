<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Service;
use App\Models\Transaksi;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::count();
        
        $totalSchedulesToday = \App\Models\Appointment::whereDate('jadwal', now()->toDateString())->count();
        
        $revenueThisMonth = \DB::table('transaksi as t')
                            ->join('appointments as a', 't.appointment_id', '=', 'a.id')
                            ->join('services as s', 'a.service_id', '=', 's.id')
                            ->whereMonth('t.created_at', now()->month)
                            ->whereYear('t.created_at', now()->year)
                            ->sum('s.harga');

        $latestCustomers = User::where('role', 'customer')
                             ->latest()
                             ->take(5)
                             ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalServices',
            'totalSchedulesToday',
            'revenueThisMonth',
            'latestCustomers'
        ));
    }

    public function pelangganIndex()
    {
        $data = User::whereIn('role', ['customer', 'pegawai'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        
        return view('admin.pelanggan.index', compact('data'));
    }

    public function pelangganStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

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

    public function pelangganUpdate(Request $request, User $pelanggan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $pelanggan->update([
            'name' => $request->name,
            'telepon' => $request->telepon, 
            'email' => $request->email,     
            'alamat' => $request->alamat,  
        ]);

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function pelangganDestroy(User $pelanggan)
    {
        Transaksi::where('customer_id', $pelanggan->id)->delete();
        
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function layananIndex()
    {
        $data = Service::orderBy('nama', 'asc')->paginate(10);
        
        return view('admin.layanan.index', compact('data'));
    }

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

    public function layananDestroy(Service $layanan)
    {
        Transaction::where('service_id', $layanan->id)->delete();

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }

    public function jadwalIndex()
    {
        $appointments = Appointment::with(['user', 'service', 'stylist'])->get(); 
        $staff = User::where('role', 'pegawai')->get(); 

        return view('admin.jadwal.index', compact('appointments', 'staff'));
    }

    public function showActivityLogs()
    {
        $cancellation_activities = [
            'APPOINTMENT_CANCELLED',
            'TRANSACTION_CANCELLED', 
            'USER_DELETED',       
            'SERVICE_DELETED',      
            'APPOINTMENT_DELETED',  
        ];

        $logs = DB::table('activity_logs as al')
                ->join('users as u', 'al.user_id', '=', 'u.id')
                ->select([
                    'al.id',
                    'al.activity_type',
                    'al.description',
                    'al.created_at',
                    'u.name AS user_name',
                    'u.role AS user_role'
                ])
                ->whereIn('al.activity_type', $cancellation_activities)
                ->orderBy('al.created_at', 'desc')
                ->paginate(20);

        return view('admin.riwayat.index', compact('logs'));
    }
}