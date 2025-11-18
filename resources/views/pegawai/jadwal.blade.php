@extends('pegawai.app') 

@section('title', 'Jadwal Layanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 py-8">
    <div class="container mx-auto px-4">
        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2 flex items-center">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Jadwal Layanan
                        </h1>
                        <p class="text-pink-100 text-lg">Kelola dan pantau semua jadwal layanan Anda</p>
                    </div>
                    <div class="flex gap-3">
                        <button class="bg-white/20 backdrop-blur-sm rounded-xl px-5 py-3 border border-white/30 hover:bg-white/30 transition flex items-center gap-2">
                            <i class="fas fa-filter"></i>
                            <span class="font-medium">Filter</span>
                        </button>
                        <button class="bg-white text-pink-600 rounded-xl px-5 py-3 hover:shadow-xl transition flex items-center gap-2 font-bold">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Hari Ini</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendar Navigation --}}
        <div class="bg-white rounded-3xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-calendar text-pink-500 mr-3"></i>
                    November 2024
                </h2>
                <div class="flex gap-2">
                    <button class="bg-pink-100 text-pink-600 px-4 py-2 rounded-xl hover:bg-pink-200 transition">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="bg-pink-100 text-pink-600 px-4 py-2 rounded-xl hover:bg-pink-200 transition">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            {{-- Week Days --}}
            <div class="grid grid-cols-7 gap-2 mb-4">
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                <div class="text-center font-bold text-gray-600 text-sm py-2">{{ $day }}</div>
                @endforeach
            </div>

            {{-- Calendar Dates --}}
            <div class="grid grid-cols-7 gap-2">
                @php
                    $dates = [
                        ['date' => '', 'count' => 0],
                        ['date' => '', 'count' => 0],
                        ['date' => '', 'count' => 0],
                        ['date' => 1, 'count' => 2],
                        ['date' => 2, 'count' => 1],
                        ['date' => 3, 'count' => 0],
                        ['date' => 4, 'count' => 3],
                        ['date' => 5, 'count' => 1],
                        ['date' => 6, 'count' => 2],
                        ['date' => 7, 'count' => 4],
                        ['date' => 8, 'count' => 2],
                        ['date' => 9, 'count' => 0],
                        ['date' => 10, 'count' => 1],
                        ['date' => 11, 'count' => 0],
                        ['date' => 12, 'count' => 3],
                        ['date' => 13, 'count' => 2],
                        ['date' => 14, 'count' => 1],
                        ['date' => 15, 'count' => 3],
                        ['date' => 16, 'count' => 2],
                        ['date' => 17, 'count' => 0],
                        ['date' => 18, 'count' => 1],
                    ];
                @endphp

                @foreach($dates as $item)
                    @if($item['date'])
                        <div class="relative group">
                            <button class="w-full aspect-square rounded-xl hover:shadow-lg transition-all {{ $item['date'] == 15 ? 'bg-gradient-to-br from-pink-500 to-rose-500 text-white shadow-lg scale-105' : ($item['count'] > 0 ? 'bg-pink-50 text-gray-800 hover:bg-pink-100' : 'bg-gray-50 text-gray-600 hover:bg-gray-100') }}">
                                <div class="font-semibold">{{ $item['date'] }}</div>
                                @if($item['count'] > 0)
                                <div class="text-xs mt-1 {{ $item['date'] == 15 ? 'text-pink-100' : 'text-pink-600' }}">{{ $item['count'] }} jadwal</div>
                                @endif
                            </button>
                        </div>
                    @else
                        <div class="w-full aspect-square"></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Schedule List --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Filter Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-sliders-h text-pink-500 mr-2"></i>
                        Filter Jadwal
                    </h3>

                    {{-- Status Filter --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" checked class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Semua Status</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Menunggu</span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" class="w-5 h-5 text-pink-600 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700 group-hover:text-pink-600 transition">Selesai</span>
                            </label>
                        </div>
                    </div>

                    {{-- Service Type Filter --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Layanan</label>
                        <select class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 outline-none transition">
                            <option>Semua Layanan</option>
                            <option>Hair Cut & Wash</option>
                            <option>Manicure & Pedicure</option>
                            <option>Coloring & Blow Dry</option>
                            <option>Facial Treatment</option>
                        </select>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-4 border border-pink-200">
                        <h4 class="font-semibold text-gray-800 mb-3">Statistik Hari Ini</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Jadwal</span>
                                <span class="font-bold text-pink-600">8</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Selesai</span>
                                <span class="font-bold text-green-600">3</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Menunggu</span>
                                <span class="font-bold text-yellow-600">5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Schedule Cards --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-clock text-pink-500 mr-3"></i>
                            Jadwal Hari Ini
                        </h3>
                        <span class="bg-pink-100 text-pink-600 px-4 py-2 rounded-full text-sm font-bold">
                            15 November 2024
                        </span>
                    </div>

                    @php
                        $schedules = [
                            ['time' => '08:00', 'client' => 'Siti Rahma', 'service' => 'Facial Treatment', 'duration' => '60 menit', 'status' => 'Selesai', 'icon' => 'fa-spa'],
                            ['time' => '09:30', 'client' => 'Linda Wijaya', 'service' => 'Hair Cut & Wash', 'duration' => '45 menit', 'status' => 'Selesai', 'icon' => 'fa-cut'],
                            ['time' => '10:00', 'client' => 'Salwa Halila', 'service' => 'Hair Cut & Wash', 'duration' => '45 menit', 'status' => 'Menunggu', 'icon' => 'fa-cut'],
                            ['time' => '11:15', 'client' => 'Dewi Lestari', 'service' => 'Manicure & Pedicure', 'duration' => '90 menit', 'status' => 'Menunggu', 'icon' => 'fa-hand-sparkles'],
                            ['time' => '12:30', 'client' => 'Willy Armando', 'service' => 'Manicure & Pedicure', 'duration' => '90 menit', 'status' => 'Menunggu', 'icon' => 'fa-hand-sparkles'],
                            ['time' => '14:00', 'client' => 'Cindy Artika', 'service' => 'Coloring & Blow Dry', 'duration' => '120 menit', 'status' => 'Selesai', 'icon' => 'fa-spray-can'],
                            ['time' => '15:00', 'client' => 'Maya Putri', 'service' => 'Hair Spa', 'duration' => '60 menit', 'status' => 'Menunggu', 'icon' => 'fa-water'],
                            ['time' => '16:30', 'client' => 'Rina Safitri', 'service' => 'Rebonding', 'duration' => '180 menit', 'status' => 'Menunggu', 'icon' => 'fa-magic'],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($schedules as $schedule)
                        <div class="group bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-2xl p-5 hover:shadow-xl hover:border-pink-400 transition-all duration-300 hover:scale-[1.02]">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="bg-gradient-to-br from-pink-500 to-rose-500 p-4 rounded-xl text-white shrink-0 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas {{ $schedule['icon'] }} text-xl"></i>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                                            <span class="bg-pink-200 text-pink-800 px-3 py-1 rounded-full text-sm font-bold">
                                                <i class="far fa-clock mr-1"></i>{{ $schedule['time'] }}
                                            </span>
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-hourglass-half mr-1"></i>{{ $schedule['duration'] }}
                                            </span>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $schedule['service'] }}</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-user-circle text-pink-500 mr-2"></i>
                                            <p class="font-medium">{{ $schedule['client'] }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($schedule['status'] == 'Selesai')
                                        <span class="px-5 py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-lg flex items-center">
                                            <i class="fas fa-check-circle mr-2"></i> Selesai
                                        </span>
                                    @else
                                        <span class="px-5 py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg flex items-center">
                                            <i class="fas fa-hourglass-half mr-2"></i> Menunggu
                                        </span>
                                        <button class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-5 py-2.5 text-sm rounded-xl hover:from-pink-600 hover:to-rose-600 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <i class="fas fa-play mr-2"></i>Mulai
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Additional Details (Hidden by default, shown on hover or click) --}}
                            <div class="mt-4 pt-4 border-t border-pink-200 hidden group-hover:block">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-phone text-pink-500 mr-2"></i>
                                        <span>0812-xxxx-xxxx</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope text-pink-500 mr-2"></i>
                                        <span>email@example.com</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-sticky-note text-pink-500 mr-2"></i>
                                        <span>No notes</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-dollar-sign text-pink-500 mr-2"></i>
                                        <span>Rp 150.000</span>
                                    </div>
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

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .group:hover .fa-cut,
    .group:hover .fa-hand-sparkles,
    .group:hover .fa-spray-can,
    .group:hover .fa-spa,
    .group:hover .fa-water,
    .group:hover .fa-magic {
        animation: float 2s ease-in-out infinite;
    }
</style>
@endsection