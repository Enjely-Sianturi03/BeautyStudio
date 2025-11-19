<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index() {
        $data = Jadwal::with(['pelanggan','layanan'])->latest('mulai_at')->paginate(10);
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        return view('admin.jadwal.index', compact('data','pelanggans','layanans'));
    }

    public function store(Request $request) {
        $val = $request->validate([
            'pelanggan_id'=>'required|exists:pelanggans,id',
            'layanan_id'=>'required|exists:layanans,id',
            'staf'=>'nullable|string|max:100',
            'mulai_at'=>'required|date',
            'status'=>'required|in:dijadwalkan,selesai,batal'
        ]);
        Jadwal::create($val);
        return back()->with('ok','Jadwal dibuat');
    }

    public function update(Request $request, Jadwal $jadwal) {
        $val = $request->validate([
            'pelanggan_id'=>'required|exists:pelanggans,id',
            'layanan_id'=>'required|exists:layanans,id',
            'staf'=>'nullable|string|max:100',
            'mulai_at'=>'required|date',
            'status'=>'required|in:dijadwalkan,selesai,batal'
        ]);
        $jadwal->update($val);
        return back()->with('ok','Jadwal diupdate');
    }

    public function destroy(Jadwal $jadwal) {
        $jadwal->delete();
        return back()->with('ok','Jadwal dihapus');
    }
}
