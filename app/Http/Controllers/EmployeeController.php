<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// You will likely need to import the Appointment model for the completeAppointment method
// use App\Models\Appointment; 

class EmployeeController extends Controller
{
    /**
     * Shows the main employee dashboard.
     */
    public function index() 
    {
        return view('pegawai.dashboard');
    }

    // --- NEW METHOD FOR JADWAL (SCHEDULE) ---
    /**
     * Shows the employee's schedule view.
     */
    public function schedule() 
    {
        // 1. Fetch data relevant to the employee's schedule (e.g., today's appointments)
        // $schedules = Appointment::where('employee_id', auth()->id())->get();
        
        // 2. Return the corresponding view
        return view('pegawai.jadwal');
        // NOTE: You must have a Blade file named 'jadwal.blade.php' 
        // inside the 'resources/views/pegawai/' directory.
    }

    public function history() 
    {
        return view('pegawai.riwayat');
    }

    public function completeAppointment($id)
    {
        return redirect()->route('pegawai.dashboard')->with('success', 'Appointment marked as completed (placeholder).');
    }
}