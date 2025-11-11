@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Total Pelanggan</h2>
    <p class="text-3xl font-bold text-pink-700">{{ \App\Models\Pelanggan::count() }}</p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Total Layanan</h2>
    <p class="text-3xl font-bold text-pink-700">{{ \App\Models\Layanan::count() }}</p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Jadwal Hari Ini</h2>
    <p class="text-3xl font-bold text-pink-700">{{ \App\Models\Jadwal::whereDate('mulai_at', now())->count() }}</p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Pendapatan Bulan Ini</h2>
    <p class="text-3xl font-bold text-pink-700">
      Rp {{ number_format(\App\Models\Transaksi::whereMonth('created_at', now())->sum('total'), 0, ',', '.') }}
    </p>
  </div>
</div>

<!-- Contoh Tabel Pelanggan -->
<div class="bg-white shadow rounded p-6 mb-8 border-l-4 border-pink-400">
  <div class="flex justify-between mb-4">
    <h2 class="text-xl font-semibold text-pink-700">Data Pelanggan Terbaru</h2>
    <a href="{{ route('admin.pelanggan.index') }}" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">+ Tambah</a>
  </div>
  <table class="w-full border-collapse">
    <thead class="bg-pink-200">
      <tr>
        <th class="py-2 px-3 text-left text-pink-800">Nama</th>
        <th class="py-2 px-3 text-left text-pink-800">Telepon</th>
        <th class="py-2 px-3 text-left text-pink-800">Email</th>
      </tr>
    </thead>
    <tbody>
      @foreach(\App\Models\Pelanggan::latest()->take(5)->get() as $p)
      <tr class="border-b hover:bg-pink-50">
        <td class="py-2 px-3">{{ $p->nama }}</td>
        <td class="py-2 px-3">{{ $p->telepon }}</td>
        <td class="py-2 px-3">{{ $p->email }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
