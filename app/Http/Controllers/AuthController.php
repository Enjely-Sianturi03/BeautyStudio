<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Default role otomatis (misalnya customer)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // otomatis jadi customer
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }


    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user(); 
                switch ($user->role) {
                    case 'admin':
                        return redirect()->intended('/admin/dashboard'); 
                    case 'owner':
                        return redirect()->intended('/owner/dashboard');
                    case 'pegawai':
                        return redirect()->intended('/pegawai/dashboard');
                    default:
                        return redirect()->intended('/home'); 
                }
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}