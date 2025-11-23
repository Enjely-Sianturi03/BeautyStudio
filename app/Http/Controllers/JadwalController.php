<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user','service','staff'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Ambil staf (role = staff / pegawai)
        $staff = User::where('role', 'staff')->get();

        return view('admin.jadwal.index', compact('appointments','staff'));
    }


    public function show($id)
    {
        $appointment = Appointment::with(['user','service','staff'])
            ->findOrFail($id);

        // Ambil semua staf (role staff / stylist)
        $staff = User::where('role', 'staff')->get();

        return view('admin.jadwal.show', compact('appointment', 'staff'));
    }



    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->stylist_id = $request->stylist_id;
        $appointment->save();

        return back()->with('success', 'Staf berhasil diperbarui!');
    }


    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus!');
    }

    public function assignStaff(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,id',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->staff_id = $request->staff_id;
        $appointment->save();

        return redirect()->route('admin.jadwal.show', $appointment->id)
                        ->with('success', 'Staf berhasil ditetapkan!');
    }


}
