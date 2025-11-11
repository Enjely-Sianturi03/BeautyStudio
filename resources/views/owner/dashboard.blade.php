@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            Owner Panel
        </div>
        <nav class="flex-1 p-4 space-y-3">
            <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 rounded-lg bg-gray-800 text-white font-medium hover:bg-gray-700">
                Dashboard
            </a>
            <a href="#" class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                Kelola Layanan
            </a>
            <a href="#" class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                Kelola Pelanggan
            </a>
            <a href="#" class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                Riwayat Transaksi
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-center bg-red-600 hover:bg-red-500 rounded-lg font-semibold">
                Kembali ke Website
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-serif font-bold text-gray-800 mb-6">Dashboard Owner Salon</h1>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pelanggan</p>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $totalCustomers ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-users text-indigo-500 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Layanan</p>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $totalServices ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-spa text-green-500 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pendapatan</p>
                        <h2 class="text-3xl font-bold text-gray-900">
                            Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                        </h2>
                    </div>
                    <i class="fas fa-coins text-yellow-500 text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Riwayat Transaksi</h2>
                <span class="text-sm text-gray-500">Total: {{ count($transactions ?? []) }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Layanan</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions ?? [] as $t)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3">{{ $t->date ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->customer->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->service->name ?? '-' }}</td>
                                <td class="px-6 py-3 font-semibold">Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-400">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection