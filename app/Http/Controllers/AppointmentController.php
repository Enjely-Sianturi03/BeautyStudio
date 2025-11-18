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
    $validated = $request->validate([
        'name' => 'required|string|max:255', // ✅ Tambah nama
        'service_id' => 'required|exists:services,id',
        'stylist_id' => 'nullable|exists:stylists,id',
        'appointment_date' => 'required|date|after:today',
        'appointment_time' => 'required',
        'notes' => 'nullable|string|max:500',

        'payment_method' => 'required|string',
        'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Jika tidak pakai stylist
    $validated['stylist_id'] = $request->stylist_id ?? null;

    // Cek jadwal bentrok
    $existingAppointment = Appointment::where('appointment_date', $validated['appointment_date'])
        ->where('appointment_time', $validated['appointment_time'])
        ->whereIn('status', ['pending', 'confirmed'])
        ->exists();

    if ($existingAppointment) {
        return back()->withErrors([
            'appointment_time' => 'This time slot is already booked.'
        ])->withInput();
    }

    // Upload bukti
    $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
    $validated['payment_proof'] = $proofPath;

    // Tambahkan user ID & status
    $validated['user_id'] = Auth::id();
    $validated['status'] = 'pending';

    // ✅ Tambahkan name ke database
    $validated['name'] = $request->name;

    // Simpan
    $appointment = Appointment::create($validated);

    return redirect()->route('appointments.show', $appointment)
        ->with('success', 'Appointment booked successfully!');
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
}
