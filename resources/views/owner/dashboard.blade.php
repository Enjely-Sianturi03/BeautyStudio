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

    <!-- Main Content -->
    <main class="flex-1 p-8 space-y-12">
        
        <h1 class="text-3xl font-serif font-bold text-pink-800 mb-6">Dashboard Owner Salon</h1>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-pink-500">
                <p class="text-pink-500 text-sm">Total Pelanggan</p>
                <h2 class="text-3xl font-bold text-pink-900">{{ $totalCustomers }}</h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-pink-400">
                <p class="text-pink-500 text-sm">Total Layanan</p>
                <h2 class="text-3xl font-bold text-pink-900">{{ $totalServices }}</h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-pink-300">
                <p class="text-pink-500 text-sm">Total Pendapatan</p>
                <h2 class="text-3xl font-bold text-pink-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            </div>

        </div>

        <!-- Tabel Transaksi -->
        <div class="bg-white p-6 rounded-xl shadow-md">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-pink-800">Riwayat Transaksi</h2>
                <a href="{{ route('owner.transactions.pdf') }}" target="_blank"
                   class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-500 text-sm font-semibold">Cetak PDF</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-pink-200 rounded-lg">
                    <thead class="bg-pink-100 text-pink-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Layanan</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $t)
                            <tr class="border-b hover:bg-pink-50 transition">
                                <td class="px-6 py-3">{{ $t->appointment_date }}</td>
                                <td class="px-6 py-3">{{ $t->user->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->service->nama ?? '-' }}</td>
                                <td class="px-6 py-3 font-semibold text-pink-700">
                                    Rp {{ number_format($t->service->harga ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-pink-400">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

<!-- DATA PELANGGAN -->
<section id="pelanggan" class="bg-white p-6 rounded-xl shadow-md mt-12">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-pink-800">Daftar Pelanggan</h2>
        <span class="text-sm text-gray-500">Total: {{ count($customers) }} pelanggan</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-pink-200 rounded-lg">
            <thead class="bg-pink-100 text-pink-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Telepon</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr class="border-b hover:bg-pink-50 transition">
                        <td class="px-4 py-3 font-medium">{{ $customer->name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $customer->email }}</td>
                        <td class="px-4 py-3">{{ $customer->telepon ?? '-' }}</td>

                        <td class="px-4 py-3 text-center">
                            <!-- Tombol Hapus -->
                            <form method="POST"
                                action="{{ route('admin.pelanggan.destroy', $customer->id) }}"
                                class="inline"
                                onsubmit="return confirm('Hapus pelanggan {{ $customer->name }}?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                            Belum ada data pelanggan.
                        </td>
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

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartRevenue');

const weeklyData = {
    1: {{ $weeklyRevenue[1] ?? 0 }},
    2: {{ $weeklyRevenue[2] ?? 0 }},
    3: {{ $weeklyRevenue[3] ?? 0 }},
    4: {{ $weeklyRevenue[4] ?? 0 }},
    5: {{ $weeklyRevenue[5] ?? 0 }},
    6: {{ $weeklyRevenue[6] ?? 0 }},
    7: {{ $weeklyRevenue[7] ?? 0 }},
};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [
                weeklyData[1],
                weeklyData[2],
                weeklyData[3],
                weeklyData[4],
                weeklyData[5],
                weeklyData[6],
                weeklyData[7],
            ],
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
