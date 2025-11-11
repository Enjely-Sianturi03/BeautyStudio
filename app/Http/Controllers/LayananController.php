<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index() {
        $data = Layanan::latest()->paginate(10);
        return view('admin.layanan.index', compact('data'));
    }

    public function store(Request $request) {
        $val = $request->validate([
            'nama'=>'required|string|max:100',
            'deskripsi'=>'nullable|string',
            'durasi_menit'=>'required|integer|min:10',
            'harga'=>'required|integer|min:0'
        ]);
        Layanan::create($val);
        return back()->with('ok','Layanan ditambahkan');
    }

    public function update(Request $request, Layanan $layanan) {
        $val = $request->validate([
            'nama'=>'required|string|max:100',
            'deskripsi'=>'nullable|string',
            'durasi_menit'=>'required|integer|min:10',
            'harga'=>'required|integer|min:0'
        ]);
        $layanan->update($val);
        return back()->with('ok','Layanan diupdate');
    }

    public function destroy(Layanan $layanan) {
        $layanan->delete();
        return back()->with('ok','Layanan dihapus');
    }
}
