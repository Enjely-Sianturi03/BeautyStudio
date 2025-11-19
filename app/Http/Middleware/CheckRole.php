<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika role user tidak sesuai
        if ($user->role !== $role) {
            // Arahkan kembali ke dashboard sesuai role-nya
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'owner':
                    return redirect()->route('owner.dashboard');
                case 'pegawai':
                    return redirect()->route('pegawai.dashboard');
                case 'customer':
                    return redirect()->route('customer.dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
