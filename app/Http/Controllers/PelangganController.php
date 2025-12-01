<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index() 
    {
        $data = User::orderBy('id','DESC')->paginate(10);
        return view('admin.pelanggan.index', compact('data'));
    }

    public function store(Request $request) 
    {
        $val = $request->validate([
            'name'     => 'required|string|max:100',
            'telepon'  => 'nullable|string|max:30',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:5',
            'role'     => 'required|in:customer,pegawai'
        ]);

        User::create([
            'name'     => $val['name'],
            'telepon'  => $val['telepon'],
            'email'    => $val['email'],
            'password' => Hash::make($val['password']),
            'role'     => $val['role'],
        ]);

        return back()->with('ok', 'Akun berhasil ditambahkan');
    }

    public function update(Request $request, User $pelanggan) 
    {
        $val = $request->validate([
            'name'     => 'required|string|max:100',
            'telepon'  => 'nullable|string|max:30',
            'email'    => 'nullable|email|unique:users,email,' . $pelanggan->id,
            'role'     => 'required|in:customer,pegawai'
        ]);

        $pelanggan->update($val);

        return back()->with('ok', 'Akun berhasil diupdate');
    }

    public function destroy(User $pelanggan) 
    {
        $pelanggan->delete();
        return back()->with('ok', 'Akun dihapus');
    }
}
