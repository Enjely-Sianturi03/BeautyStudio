<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'tanggal' => 'required|date',
            'layanan' => 'required',
        ]);

        return back()->with('success', 'Booking berhasil dikirim! Kami akan menghubungi Anda segera 😊');
    }
}
