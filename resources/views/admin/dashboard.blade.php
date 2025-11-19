@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page', 'Dashboard Admin')

@section('content')
<!-- Kartu Statistik -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Total Pelanggan</h2>
    <!-- Menggunakan variabel $totalCustomers dari Controller -->
    <p class="text-3xl font-bold text-pink-700">{{ $totalCustomers }}</p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Total Layanan</h2>
    <!-- Menggunakan variabel $totalServices dari Controller -->
    <p class="text-3xl font-bold text-pink-700">{{ $totalServices }}</p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Jadwal Hari Ini</h2>
    <!-- Menggunakan variabel $totalSchedulesToday dari Controller -->
    <p class="text-3xl font-bold text-pink-700">{{ $totalSchedulesToday }}</p>
  </div>
  <div class="bg-pink-200 shadow rounded p-4 text-center border-t-4 border-pink-400">
    <h2 class="text-pink-800">Pendapatan Bulan Ini</h2>
    <p class="text-3xl font-bold text-pink-700">
      <!-- Menggunakan variabel $revenueThisMonth dari Controller -->
      Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}
    </p>
  </div>
</div>

<!-- Tabel Pelanggan Terbaru -->
<div class="bg-white shadow rounded p-6 mb-8 border-l-4 border-pink-400">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-pink-700">Data Pelanggan Terbaru</h2>
    <a href="{{ route('admin.pelanggan.index') }}" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition duration-150 text-sm">Lihat Semua</a>
  </div>
  <div class="overflow-x-auto">
      <table class="min-w-full border-collapse">
        <thead class="bg-pink-200">
          <tr>
            <th class="py-2 px-3 text-left text-pink-800">Nama</th>
            <th class="py-2 px-3 text-left text-pink-800">Telepon</th>
            <th class="py-2 px-3 text-left text-pink-800">Email</th>
          </tr>
        </thead>
        <tbody>
          <!-- Menggunakan variabel $latestCustomers dari Controller -->
          @forelse($latestCustomers as $p)
          <tr class="border-b hover:bg-pink-50">
            <td class="py-2 px-3">{{ $p->name }}</td>
            <td class="py-2 px-3">{{ $p->telepon ?? '-' }}</td>
            <td class="py-2 px-3">{{ $p->email }}</td>
          </tr>
          @empty
          <tr class="border-b">
              <td colspan="3" class="py-4 px-3 text-center text-gray-500">Tidak ada data pelanggan terbaru.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
  </div>
</div>
@endsection
