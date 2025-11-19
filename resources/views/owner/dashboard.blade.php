@extends('layouts.owner')

@section('title', 'Owner Dashboard')

@section('content')
<div class="min-h-screen bg-pink-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-pink-900 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-pink-700">
            Owner Panel
        </div>
        <nav class="flex-1 p-4 space-y-3">
            <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 rounded-lg bg-pink-800 text-white font-medium hover:bg-pink-700">
                Dashboard
            </a>
            <a href="#layanan" class="block px-4 py-2 rounded-lg text-pink-200 hover:bg-pink-700 hover:text-white">
                Kelola Layanan
            </a>
            <a href="#pelanggan" class="block px-4 py-2 rounded-lg text-pink-200 hover:bg-pink-700 hover:text-white">
                Kelola Pelanggan
            </a>
            <a href="#laporan" class="block px-4 py-2 rounded-lg text-pink-200 hover:bg-pink-700 hover:text-white">
                Laporan Pendapatan
            </a>
        </nav>
        <div class="p-4 border-t border-pink-700">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-center bg-pink-600 hover:bg-pink-500 rounded-lg font-semibold">
                Kembali ke Website
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8 space-y-12">
        <h1 class="text-3xl font-serif font-bold text-pink-800 mb-6">Dashboard Owner Salon</h1>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-pink-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-500 text-sm">Total Pelanggan</p>
                        <h2 class="text-3xl font-bold text-pink-900">{{ $totalCustomers ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-users text-pink-500 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-pink-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-500 text-sm">Total Layanan</p>
                        <h2 class="text-3xl font-bold text-pink-900">{{ $totalServices ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-spa text-pink-400 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-pink-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-500 text-sm">Total Pendapatan</p>
                        <h2 class="text-3xl font-bold text-pink-900">
                            Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                        </h2>
                    </div>
                    <i class="fas fa-coins text-pink-300 text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-pink-800">Riwayat Transaksi</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-pink-500">Total: {{ count($transactions ?? []) }}</span>
                    <a href="{{ route('owner.transactions.pdf') }}" target="_blank" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-500 text-sm font-semibold">Cetak PDF</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm border border-pink-200 rounded-lg">
                    <thead class="bg-pink-100 text-pink-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Layanan</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions ?? [] as $t)
                            <tr class="border-b hover:bg-pink-50 transition">
                                <td class="px-6 py-3">{{ $t->date ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->customer->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->service->name ?? '-' }}</td>
                                <td class="px-6 py-3 font-semibold text-pink-700">Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-pink-400">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    <!-- Kelola Layanan -->
    <section id="layanan" class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-pink-800 mb-4">Kelola Layanan</h2>
        
        <!-- Form Tambah Layanan -->
        <form method="POST" action="{{ route('admin.layanan.store') }}" class="mb-4 flex gap-3">
            @csrf
            <input type="text" name="nama" placeholder="Nama Layanan" class="border border-pink-300 rounded-lg px-4 py-2 flex-1" required>
            <input type="number" name="harga" placeholder="Harga (Rp)" class="border border-pink-300 rounded-lg px-4 py-2 w-40" required>
            <!-- Tambahkan input Durasi Menit sesuai Controller -->
            <input type="number" name="durasi_menit" placeholder="Durasi (Menit)" class="border border-pink-300 rounded-lg px-4 py-2 w-40" required>
            
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-500 transition duration-150">
                Tambah
            </button>
        </form>

        <!-- Tabel Layanan (DATA DINAMIS) -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-pink-200 rounded-lg">
                <thead class="bg-pink-100 text-pink-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Harga</th>
                        <th class="px-4 py-2 text-left">Durasi</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr class="border-b hover:bg-pink-50">
                        <td class="px-4 py-2">{{ $service->nama }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($service->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $service->durasi_menit }} Menit</td>
                        <td class="px-4 py-2 text-center flex items-center justify-center space-x-2">
                            
                            {{-- Tautan Edit dihilangkan atau dikomentari untuk menghindari RouteNotFoundException --}}
                            {{-- <a href="{{ route('admin.layanan.edit', $service) }}" class="text-pink-500 hover:underline">Edit</a> | --}}
                            
                            <!-- Form Hapus -->
                            <form method="POST" action="{{ route('admin.layanan.destroy', $service->id) }}" class="inline" onsubmit="return confirm('Hapus layanan {{ $service->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-pink-700 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada layanan yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- Kelola Pelanggan -->
    <section id="pelanggan" class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-pink-800 mb-4">Daftar Pelanggan</h2>
        
        <!-- Tabel Pelanggan (DATA DINAMIS) -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-pink-200 rounded-lg">
                <thead class="bg-pink-100 text-pink-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Telepon</th> 
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr class="border-b hover:bg-pink-50">
                        <td class="px-4 py-2">{{ $customer->name }}</td>
                        <td class="px-4 py-2">{{ $customer->email }}</td>
                        <td class="px-4 py-2">{{ $customer->telepon ?? '-' }}</td> 
                        <td class="px-4 py-2 text-center">
                            <!-- Aksi Hapus Pelanggan -->
                            <form method="POST" action="{{ route('admin.pelanggan.destroy', $customer->id) }}" class="inline" onsubmit="return confirm('Hapus pelanggan {{ $customer->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-pink-700 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada data pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

        <!-- Laporan Pendapatan -->
        <section id="laporan" class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold text-pink-800 mb-4">Laporan Pendapatan Mingguan</h2>
            <canvas id="chartRevenue" class="w-full h-64"></canvas>
        </section>
    </main>
</div>

<!-- Script ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartRevenue');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [200000, 350000, 400000, 300000, 500000, 450000, 600000],
            backgroundColor: '#f9a8d4',
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection
