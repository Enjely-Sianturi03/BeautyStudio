@extends('layouts.admin')
@section('title','Dashboard Admin')
@section('page','Dashboard Admin')

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
    <p class="text-3xl font-bold text-pink-700">
      {{ \App\Models\Jadwal::whereDate('mulai_at', now())->count() }}
    </p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Pendapatan Bulan Ini</h2>
    <p class="text-3xl font-bold text-pink-700">
      Rp {{ number_format(\App\Models\Transaksi::whereMonth('created_at', now())->sum('total'),0,',','.') }}
    </p>
  </div>
</div>
@endsection
