<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Kamu bisa simpan ke DB, kirim email, dll
        // Untuk sementara:
        return back()->with('success', 'Pesan Anda berhasil dikirim!');
    }

    public function index()
    {
        return view('contacts.contact');
    }
}
