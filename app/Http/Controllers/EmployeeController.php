<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() 
    {
        return view('pegawai.dashboard');
    }

    public function completeAppointment($id)
    {
        dd("Route Berhasil Dipanggil! ID: " . $id);
        $appointment = Appointment::findOrFail($id);
        
        $appointment->status = 'Completed';
        $appointment->completion_time = now(); 
        $appointment->save();

        return redirect()->route('pegawai.dashboard')->with('success', 'Layanan untuk ' . $appointment->client_name . ' telah berhasil diselesaikan dan dicatat!');
    }
}
