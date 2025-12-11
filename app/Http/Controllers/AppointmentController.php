<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\User; 
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $upcomingAppointments = Auth::user()->appointments()
            ->upcoming()
            ->with(['service', 'stylist'])
            ->orderBy('jadwal')
            ->orderBy('jam_mulai')
            ->get();

        $pastAppointments = Auth::user()->appointments()
            ->past()
            ->with(['service', 'stylist'])
            ->orderBy('jadwal')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view('appointments.index', compact('upcomingAppointments', 'pastAppointments'));
    }

    public function create(Request $request)
    {
        $services = Service::active()->get();
        $stylists = User::where('role', 'pegawai')->get(); 

        $selectedService = $request->has('service_id') 
            ? Service::find($request->service_id) 
            : null;

        $appointments = Auth::user()->appointments()
            ->with(['service', 'stylist'])
            ->get();

        return view('appointments.create', compact(
            'services',
            'stylists',
            'selectedService',
            'appointments'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'jadwal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'stylist_id' => 'nullable|exists:users,id',
            'payment_method' => 'nullable|string',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'jadwal' => $request->jadwal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'stylist_id' => $request->stylist_id,
            'status' => 'pending',
        ]);

        if ($request->payment_method || $request->hasFile('payment_proof')) {
            $paymentProofPath = null;
            
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')
                    ->store('payment_proofs', 'public');
            }

            Transaksi::create([
                'appointment_id' => $appointment->id,
                'service_id' => $appointment->service_id,
                'user_id' => Auth::id(),
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProofPath,
                'status' => $request->payment_method ? 'paid' : 'pending',
                'date' => $appointment->jadwal,
            ]);
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dibuat!');
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('appointments.show', compact('appointment'));
    }

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
