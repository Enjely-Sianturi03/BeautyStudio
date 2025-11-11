<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index() {
        $data = Pelanggan::latest()->paginate(10);
        return view('admin.pelanggan.index', compact('data'));
    }

    public function store(Request $request) {
        $val = $request->validate([
            'nama'=>'required|string|max:100',
            'telepon'=>'nullable|string|max:30',
            'email'=>'nullable|email',
            'alamat'=>'nullable|string'
        ]);
        Pelanggan::create($val);
        return back()->with('ok','Pelanggan ditambahkan');
    }

    public function update(Request $request, Pelanggan $pelanggan) {
        $val = $request->validate([
            'nama'=>'required|string|max:100',
            'telepon'=>'nullable|string|max:30',
            'email'=>'nullable|email',
            'alamat'=>'nullable|string'
        ]);
        $pelanggan->update($val);
        return back()->with('ok','Pelanggan diupdate');
    }

    public function destroy(Pelanggan $pelanggan) {
        $pelanggan->delete();
        return back()->with('ok','Pelanggan dihapus');
    }
}
