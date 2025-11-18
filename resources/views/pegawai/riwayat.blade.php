@extends('pegawai.app') 

@section('title', 'Riwayat Layanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 py-8">
    <div class="container mx-auto px-4">
        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2 flex items-center">
                            <i class="fas fa-history mr-3"></i>
                            Riwayat Layanan
                        </h1>
                        <p class="text-pink-100 text-lg">Lihat semua layanan yang telah Anda selesaikan</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/30">
                        <p class="text-sm text-pink-100">Total Layanan</p>
                        <p class="text-3xl font-bold">247</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-pink-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-pink-600">42</h3>
                        <p class="text-xs text-green-600 font-semibold mt-1">
                            <i class="fas fa-arrow-up mr-1"></i> +12% dari bulan lalu
                        </p>
                    </div>
                    <div class="bg-pink-100 p-4 rounded-xl">
                        <i class="fas fa-calendar-check text-3xl text-pink-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-purple-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Minggu Ini</p>
                        <h3 class="text-3xl font-bold text-purple-600">12</h3>
                        <p class="text-xs text-green-600 font-semibold mt-1">
                            <i class="fas fa-arrow-up mr-1"></i> +5 dari minggu lalu
                        </p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-xl">
                        <i class="fas fa-chart-line text-3xl text-purple-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-rose-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Rating Rata-rata</p>
                        <h3 class="text-3xl font-bold text-rose-600 flex items-center">
                            4.8 <i class="fas fa-star text-yellow-500 text-xl ml-2"></i>
                        </h3>
                        <p class="text-xs text-gray-500 font-semibold mt-1">Dari 187 ulasan</p>
                    </div>
                    <div class="bg-rose-100 p-4 rounded-xl">
                        <i class="fas fa-star text-3xl text-rose-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-xl border-l-4 border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-blue-600">12.5M</h3>
                        <p class="text-xs text-green-600 font-semibold mt-1">
                            <i class="fas fa-arrow-up mr-1"></i> +18% bulan ini
                        </p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <i class="fas fa-dollar-sign text-3xl text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- Filter Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-filter text-pink-500 mr-2"></i>
                        Filter Riwayat
                    </h3>

                    {{-- Date Range --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Periode</label>
                        <select class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition">
                            <option>7 Hari Terakhir</option>
                            <option>30 Hari Terakhir</option>
                            <option>3 Bulan Terakhir</option>
                            <option>6 Bulan Terakhir</option>
                            <option>1 Tahun Terakhir</option>
                            <option>Semua Waktu</option>
                        </select>
                    </div>

                    {{-- Service Type --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Layanan</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" checked class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Semua</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Hair Cut</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Coloring</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Manicure</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Facial</span>
                            </label>
                        </div>
                    </div>

                    {{-- Rating Filter --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Rating</label>
                        <div class="space-y-2">
                            @for($i = 5; $i >= 1; $i--)
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 flex items-center text-gray-700 group-hover:text-pink-600 transition">
                                    @for($j = 0; $j < $i; $j++)
                                        <i class="fas fa-star text-yellow-500 text-xs"></i>
                                    @endfor
                                    <span class="ml-2">& keatas</span>
                                </span>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <button class="w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white py-3 rounded-xl font-bold hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-sync-alt mr-2"></i>Terapkan Filter
                    </button>
                </div>
            </div>

            {{-- History Cards --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl shadow-xl p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-list text-pink-500 mr-3"></i>
                            Riwayat Lengkap
                        </h3>
                        <div class="flex gap-2">
                            <button class="bg-pink-100 text-pink-600 px-4 py-2 rounded-xl hover:bg-pink-200 transition text-sm font-semibold">
                                <i class="fas fa-download mr-2"></i>Export
                            </button>
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition text-sm font-semibold">
                                <i class="fas fa-print mr-2"></i>Print
                            </button>
                        </div>
                    </div>

                    @php
                        $histories = [
                            ['date' => '15 Nov 2024', 'time' => '14:00', 'client' => 'Cindy Artika', 'service' => 'Coloring & Blow Dry', 'duration' => '120 menit', 'price' => 350000, 'rating' => 5, 'icon' => 'fa-spray-can'],
                            ['date' => '15 Nov 2024', 'time' => '09:30', 'client' => 'Linda Wijaya', 'service' => 'Hair Cut & Wash', 'duration' => '45 menit', 'price' => 150000, 'rating' => 5, 'icon' => 'fa-cut'],
                            ['date' => '15 Nov 2024', 'time' => '08:00', 'client' => 'Siti Rahma', 'service' => 'Facial Treatment', 'duration' => '60 menit', 'price' => 200000, 'rating' => 4, 'icon' => 'fa-spa'],
                            ['date' => '14 Nov 2024', 'time' => '16:00', 'client' => 'Maya Kartika', 'service' => 'Rebonding', 'duration' => '180 menit', 'price' => 500000, 'rating' => 5, 'icon' => 'fa-magic'],
                            ['date' => '14 Nov 2024', 'time' => '14:30', 'client' => 'Rina Safitri', 'service' => 'Hair Spa', 'duration' => '60 menit', 'price' => 180000, 'rating' => 4, 'icon' => 'fa-water'],
                            ['date' => '14 Nov 2024', 'time' => '11:00', 'client' => 'Dewi Lestari', 'service' => 'Manicure & Pedicure', 'duration' => '90 menit', 'price' => 250000, 'rating' => 5, 'icon' => 'fa-hand-sparkles'],
                            ['date' => '13 Nov 2024', 'time' => '15:30', 'client' => 'Putri Amelia', 'service' => 'Hair Treatment', 'duration' => '75 menit', 'price' => 220000, 'rating' => 5, 'icon' => 'fa-prescription-bottle'],
                            ['date' => '13 Nov 2024', 'time' => '10:00', 'client' => 'Salwa Halila', 'service' => 'Hair Cut & Styling', 'duration' => '60 menit', 'price' => 180000, 'rating' => 4, 'icon' => 'fa-cut'],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($histories as $history)
                        <div class="group bg-gradient-to-r from-gray-50 to-pink-50 border-2 border-gray-200 rounded-2xl p-5 hover:shadow-xl hover:border-pink-400 transition-all duration-300">
                            <div class="flex flex-col lg:flex-row justify-between gap-4">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="bg-gradient-to-br from-pink-500 to-rose-500 p-4 rounded-xl text-white shrink-0">
                                        <i class="fas {{ $history['icon'] }} text-xl"></i>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">
                                                <i class="far fa-calendar mr-1"></i>{{ $history['date'] }}
                                            </span>
                                            <span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs font-bold">
                                                <i class="far fa-clock mr-1"></i>{{ $history['time'] }}
                                            </span>
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-hourglass-half mr-1"></i>{{ $history['duration'] }}
                                            </span>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $history['service'] }}</h4>
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <i class="fas fa-user-circle text-pink-500 mr-2"></i>
                                            <p class="font-medium">{{ $history['client'] }}</p>
                                        </div>
                                        <div class="flex items-center gap-4 flex-wrap">
                                            <div class="flex items-center">
                                                @for($i = 0; $i < 5; $i++)
                                                    <i class="fas fa-star {{ $i < $history['rating'] ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-600 font-semibold">{{ $history['rating'] }}.0</span>
                                            </div>
                                            <span class="text-sm text-gray-500">•</span>
                                            <span class="text-green-600 font-bold text-lg">
                                                Rp {{ number_format($history['price'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button class="bg-pink-100 text-pink-600 px-4 py-2 rounded-xl hover:bg-pink-200 transition text-sm font-semibold">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </button>
                                    <button class="bg-purple-100 text-purple-600 px-4 py-2 rounded-xl hover:bg-purple-200 transition text-sm font-semibold">
                                        <i class="fas fa-receipt mr-1"></i>Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">1-8</span> dari <span class="font-semibold">247</span> layanan
                        </div>
                        <div class="flex gap-2">
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-semibold">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-2 rounded-xl font-semibold">1</button>
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-semibold">2</button>
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-semibold">3</button>
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-semibold">...</button>
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-semibold">31</button>
                            <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-semibold">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Performance Chart --}}
                <div class="bg-white rounded-3xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-bar text-pink-500 mr-2"></i>
                        Performa Bulanan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php
                            $months = [
                                ['month' => 'September', 'services' => 38, 'revenue' => 8500000],
                                ['month' => 'Oktober', 'services' => 45, 'revenue' => 10200000],
                                ['month' => 'November', 'services' => 42, 'revenue' => 9800000],
                            ];
                        @endphp

                        @foreach($months as $month)
                        <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-5 border border-pink-200">
                            <h4 class="font-bold text-gray-800 mb-3">{{ $month['month'] }}</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Layanan</span>
                                    <span class="font-bold text-pink-600">{{ $month['services'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Pendapatan</span>
                                    <span class="font-bold text-green-600">{{ number_format($month['revenue'] / 1000000, 1) }}M</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-gradient-to-r from-pink-500 to-rose-500 h-2 rounded-full" style="width: {{ ($month['services'] / 50) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection