<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() 
    {
        return view('pegawai.index');
    }

    public function completeAppointment($id)
    {
        dd("Route Berhasil Dipanggil! ID: " . $id);
        // 1. Cari Janji Temu berdasarkan ID
        $appointment = Appointment::findOrFail($id);
        
        // 2. Perbarui status menjadi 'Completed'
        $appointment->status = 'Completed';
        $appointment->completion_time = now(); // Tambahkan waktu penyelesaian
        $appointment->save();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('employee.dashboard')->with('success', 'Layanan untuk ' . $appointment->client_name . ' telah berhasil diselesaikan dan dicatat!');
    }
}
