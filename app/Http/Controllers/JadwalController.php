<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'stylist_id' => 'nullable|exists:users,id',
        ]);

        $appointment = Appointment::with('service')->findOrFail($id);
        $selectedStylistId = $request->input('stylist_id');

        if ($selectedStylistId) {
            $startTime = Carbon::parse($appointment->appointment_time);
            $endTime   = $startTime->copy()->addMinutes($appointment->service->durasi_menit);

            // Ambil jumlah staf yang ada
            $totalStaff = User::where('role', 'pegawai')->count();

            $conflictCount = Appointment::where('id', '!=', $appointment->id)
                ->where('appointment_date', $appointment->appointment_date)
                ->where('stylist_id', $selectedStylistId) // ✅ Hanya cek staf yang dipilih
                ->whereHas('service', function($q) use ($startTime, $endTime) {
                    $q->whereRaw("ADDTIME(appointment_time, SEC_TO_TIME(durasi_menit*60)) > ?", [$startTime->format('H:i')])
                    ->where('appointment_time', '<', $endTime->format('H:i'));
                })
                ->count();

            if ($conflictCount >= 1) { 
                return back()->withErrors(['error' => 'Staf ini sudah memiliki appointment pada waktu ini.']);
            }

            $appointment->stylist_id = $selectedStylistId;
            $appointment->save();
        }

        return back()->with('success', 'Staf berhasil diperbarui!');
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