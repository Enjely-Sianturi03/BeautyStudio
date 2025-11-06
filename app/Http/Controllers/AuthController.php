<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form register.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses data registrasi user baru.
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        // Jika sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect('/home');
        }

        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba autentikasi user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan ke halaman home (dashboard)
            return redirect()->intended('/home');
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman login, bukan root /
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
