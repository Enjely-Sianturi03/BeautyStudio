<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Stylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of user's appointments.
     */
    public function index()
    {
        $upcomingAppointments = Auth::user()->appointments()
            ->upcoming()
            ->with(['service', 'stylist'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $pastAppointments = Auth::user()->appointments()
            ->past()
            ->with(['service', 'stylist'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('upcomingAppointments', 'pastAppointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    // public function create(Request $request)
    // {
    //     $services = Service::active()->get();
    //     $stylists = Stylist::active()->get();
        
    //     $selectedService = null;
    //     if ($request->has('service_id')) {
    //         $selectedService = Service::find($request->service_id);
    //     }

    //     return view('appointments.create', compact('services', 'stylists', 'selectedService'));
    // }
    public function create(Request $request)
{
    $services = Service::active()->get();
    $stylists = Stylist::active()->get();

    $selectedService = $request->has('service_id') 
        ? Service::find($request->service_id) 
        : null;

    // AMBIL SEMUA APPOINTMENTS USER
    $appointments = Auth::user()->appointments()
        ->with(['service', 'stylist'])
        ->get();

    return view('appointments.create', compact(
        'services',
        'stylists',
        'selectedService',
        'appointments' // ✅ wajib ada
    ));
}


    /**
     * Store a newly created appointment WITH PAYMENT.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'service_id' => 'required|exists:services,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
        'payment_method' => 'required|string',
        'payment_proof' => $request->payment_method !== 'Cash' ? 'required|image|max:2048' : 'nullable|image|max:2048',
    ]);

    // Hitung jumlah booking di slot itu
    $count = Appointment::where('appointment_date', $request->appointment_date)
                        ->where('appointment_time', $request->appointment_time)
                        ->count();

    if ($count >= 3) {
        return back()->withInput()->withErrors(['appointment_time' => 'This time slot is already full (3 bookings max).']);
    }

    // Simpan appointment
    $appointment = new Appointment();
    $appointment->user_id = auth()->id();
    $appointment->name = $request->name;
    $appointment->service_id = $request->service_id;
    $appointment->appointment_date = $request->appointment_date;
    $appointment->appointment_time = $request->appointment_time;
    $appointment->payment_method = $request->payment_method;

    if ($request->hasFile('payment_proof')) {
        $appointment->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
    }

    $appointment->save();

    return redirect()->route('appointments.index')->with('success', 'Appointment successfully booked!');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Cancel the specified appointment.
     */
    public function cancel(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if (!$appointment->canBeCancelled()) {
            return back()->withErrors([
                'error' => 'This appointment cannot be cancelled.'
            ]);
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi / Appointment berhasil dihapus!');
    }

}
