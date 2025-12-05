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
        ->whereIn('status', ['confirmed', 'completed']) // hanya ambil yang dikonfirmasi dan selesai
        ->orderBy('jadwal')
        ->orderBy('jam_mulai')
        ->get()
        ->map(function($appointment) {
            if ($appointment->service && $appointment->jam_mulai) {
                $appointment->jam_selesai = \Carbon\Carbon::parse($appointment->jam_mulai)
                    ->addMinutes($appointment->service->durasi_menit)
                    ->format('H:i'); 
            } else {
                $appointment->jam_selesai = null;
            }
            return $appointment;
        });

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
            $startTime = Carbon::parse($appointment->jam_mulai);
            $endTime   = $startTime->copy()->addMinutes($appointment->service->durasi_menit);

            // Ambil semua appointment staf yang sama di tanggal itu, kecuali appointment ini
            $staffAppointments = Appointment::with('service')
                ->where('jadwal', $appointment->jadwal)
                ->where('stylist_id', $selectedStylistId)
                ->where('id', '!=', $appointment->id)
                ->get();

            // Cek tumpang tindih di PHP
            foreach ($staffAppointments as $other) {
                $otherStart = Carbon::parse($other->jam_mulai);
                $otherEnd   = $otherStart->copy()->addMinutes($other->service->durasi_menit);

                if ($startTime < $otherEnd && $endTime > $otherStart) {
                    return back()->withErrors(['error' => 'Staf ini sudah memiliki appointment pada waktu yang sama.']);
                }
            }

            // Kalau tidak bentrok, simpan
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