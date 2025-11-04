@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <header class="mb-10">
            <h1 class="text-4xl font-serif font-bold text-gray-800">
                <i class="fas fa-chart-line text-pink-600 mr-3"></i> Owner Dashboard
            </h1>
            <p class="text-gray-500 mt-2">Overview Kinerja dan Laporan Operasional Salon</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-pink-500 hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 bg-pink-100 rounded-full mr-4">
                        <i class="fas fa-dollar-sign text-2xl text-pink-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan (Bulan Ini)</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">Rp 120.500.000</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-purple-500 hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full mr-4">
                        <i class="fas fa-receipt text-2xl text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">450</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-green-500 hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <i class="fas fa-user-plus text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pelanggan Baru (Bulan Ini)</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">85</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-blue-500 hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <i class="fas fa-cut text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Layanan Paling Diminati</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">Hair Coloring</p>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="text-2xl font-light mb-6 text-gray-700 font-serif">Akses Cepat ke Laporan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            
            <a href="{{ route('owner.reports.transactions') }}" class="block bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:scale-[1.02] border-l-4 border-red-500">
                <i class="fas fa-file-invoice-dollar text-4xl text-red-500 mb-3"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Laporan Transaksi</h3>
                <p class="text-gray-600 text-sm">Rekap transaksi harian, mingguan, dan bulanan[cite: 387, 399].</p>
            </a>

            <a href="{{ route('owner.reports.customers') }}" class="block bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:scale-[1.02] border-l-4 border-orange-500">
                <i class="fas fa-users text-4xl text-orange-500 mb-3"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Laporan Data Pelanggan</h3>
                <p class="text-gray-600 text-sm">Analisis data pelanggan aktif dan riwayat layanan[cite: 387, 399].</p>
            </a>

            <a href="{{ route('owner.reports.inventory') }}" class="block bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:scale-[1.02] border-l-4 border-cyan-500">
                <i class="fas fa-boxes text-4xl text-cyan-500 mb-3"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Laporan Stok Produk</h3>
                <p class="text-gray-600 text-sm">Memantau ketersediaan dan penggunaan produk kecantikan.</p>
            </a>
        </div>
        
        <h2 class="text-2xl font-light mb-6 text-gray-700 font-serif">Tren Kinerja Salon</h2>
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <p class="text-center text-gray-500 italic">
                [Placeholder Grafik: Total Pendapatan vs. Jumlah Pelanggan (Bulanan)]
            </p>
            <div class="h-64 flex items-center justify-center bg-gray-50 border border-dashed mt-4 rounded">
                <span class="text-gray-400">Area Grafik Laporan Bulanan</span>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    
</script>
@endpush