<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Service;
use App\Models\Transaksi;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

// Import MODEL VIEW
use App\Models\DashboardStats;
use App\Models\LatestCustomer;
use App\Models\TodayAppointment;
use App\Models\MonthlyRevenue;

class AdminController extends Controller
{
    public function index()
    {
        // GUNAKAN VIEW - Ambil statistik dashboard
        $stats = DashboardStats::first();
        
        $totalCustomers = $stats->total_customers ?? 0;
        $totalServices = $stats->total_services ?? 0;
        $totalSchedulesToday = $stats->total_schedules_today ?? 0;
        $revenueThisMonth = $stats->revenue_this_month ?? 0;

        // GUNAKAN VIEW - Ambil 5 pelanggan terbaru
        $latestCustomers = LatestCustomer::limit(5)->get();

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
        Transaksi::where('user_id', $pelanggan->id)->delete();
        
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
        Transaksi::where('service_id', $layanan->id)->delete();

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }

    public function jadwalIndex()
    {
        // OPTIONAL: Bisa gunakan TodayAppointment view jika hanya hari ini
        // $appointments = TodayAppointment::all();
        
        // Atau tetap gunakan eloquent untuk semua jadwal
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