<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Menampilkan semua jadwal appointment.
     */
    public function index()
    {
        $appointments = Appointment::with(['user','service','stylist'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Ambil semua staf / pegawai (role 'pegawai')
        $staff = User::where('role', 'pegawai')->get();

        return view('admin.jadwal.index', compact('appointments','staff'));
    }

    /**
     * Menampilkan detail appointment.
     */
    public function show($id)
    {
        $appointment = Appointment::with(['user','service','stylist'])
            ->findOrFail($id);

        $staff = User::where('role', 'pegawai')->get();

        return view('admin.jadwal.show', compact('appointment', 'staff'));
    }

    /**
     * Update appointment (menetapkan staf/stylist).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stylist_id' => 'nullable|exists:users,id',
        ]);

        $appointment = Appointment::findOrFail($id);

        // Ambil stylist id dari input
        $stylistId = $request->input('stylist_id');
        $appointment->stylist_id = $stylistId;
        $appointment->save();

        // --- OPTIONAL: Buat notifikasi untuk stylist (lihat B untuk 2 metode) ---
        if ($stylistId) {
            // Metode A (direkomendasikan): Laravel Notification
            // Metode B (fallback): insert ke tabel notification_logs
        }

        // Tetap kembali ke halaman admin, tampilkan pesan sukses yang jelas
        return back()->with('success', 'Staf berhasil diperbarui! Stylist akan melihat jadwal ketika mereka login.');
    }


    /**
     * Hapus appointment.
     */
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
