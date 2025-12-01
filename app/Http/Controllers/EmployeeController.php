<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Menampilkan dashboard pegawai (jadwal hari ini).
     */
    public function index()
    {
        // Ambil semua appointment hari ini untuk stylist yang login
        $appointments = Appointment::with(['user', 'service'])
            ->where('stylist_id', Auth::id())
            ->whereDate('appointment_date', now()->toDateString())
            ->orderBy('appointment_time')
            ->get();

        // Hitung statistik (pastikan status disimpan lowercase di DB)
        $total = $appointments->count();
        $completed = $appointments->where('status', 'completed')->count();
        $pending = $appointments->where('status', 'pending')->count();

        return view('pegawai.dashboard', compact('appointments', 'total', 'completed', 'pending'));
    }

    /**
     * Menampilkan semua jadwal pegawai.
     */
    public function schedule()
    {
        $schedules = Appointment::where('stylist_id', Auth::id())
            ->where('status', '!=', 'completed')     
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('pegawai.jadwal', compact('schedules'));
    }
    
    public function history()
    {
        $history = Appointment::where('stylist_id', Auth::id())
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('pegawai.riwayat', compact('history'));
    }

    /**
     * Menandai appointment sebagai selesai.
     */
    public function completeAppointment($id)
    {
        $appointment = Appointment::where('stylist_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $appointment->status = 'completed';
        $appointment->save();

        return redirect()->back()->with('success', 'Layanan berhasil diselesaikan.');
    }

    /**
     * Menampilkan daftar pelanggan
     */
    public function customers()
    {
        $customers = Appointment::where('stylist_id', Auth::id())
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique('id');

        return view('pegawai.customers', compact('customers'));
    }
}
