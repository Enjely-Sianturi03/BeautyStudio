@extends('pegawai.app') 

@section('title', 'Pegawai Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        {{-- Header Section with Gradient --}}
        <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">✨ Halo, {{ Auth::user()->name }}!</h1>
                        <p class="text-pink-100 text-lg">Semangat melayani dengan sepenuh hati hari ini! 💖</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/30">
                        <p class="text-sm text-pink-100">Hari Ini</p>
                        <p class="text-2xl font-bold">{{ date('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content - Jadwal Layanan --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-pink-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Layanan</p>
                                <h3 class="text-3xl font-bold text-pink-600 mt-1">{{ count($appointments ?? []) }}</h3>
                            </div>
                            <div class="bg-pink-100 p-4 rounded-xl">
                                <i class="fas fa-clipboard-list text-2xl text-pink-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-rose-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Selesai</p>
                                <h3 class="text-3xl font-bold text-rose-600 mt-1">1</h3>
                            </div>
                            <div class="bg-rose-100 p-4 rounded-xl">
                                <i class="fas fa-check-circle text-2xl text-rose-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Menunggu</p>
                                <h3 class="text-3xl font-bold text-purple-600 mt-1">2</h3>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-xl">
                                <i class="fas fa-clock text-2xl text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Layanan Card --}}
                <div class="bg-white rounded-3xl shadow-2xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-3 rounded-xl mr-4">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800">Jadwal Layanan Hari Ini</h2>
                    </div>

                    @php
                        $appointments = [
                            (object)['id' => 1, 'time' => '10:00', 'client_name' => 'Salwa Halila', 'service' => 'Hair Cut & Wash', 'status' => 'Pending', 'icon' => 'fa-cut'],
                            (object)['id' => 2, 'time' => '12:30', 'client_name' => 'Willy Armando', 'service' => 'Manicure & Pedicure', 'status' => 'Pending', 'icon' => 'fa-hand-sparkles'],
                            (object)['id' => 3, 'time' => '14:00', 'client_name' => 'Cindy Artika', 'service' => 'Coloring & Blow Dry', 'status' => 'Completed', 'icon' => 'fa-spray-can'],
                        ];
                    @endphp

                    @if(count($appointments) > 0)
                        <div class="space-y-4">
                            @foreach($appointments as $appointment)
                                <div class="group bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-2xl p-6 transition-all duration-300 hover:shadow-xl hover:border-pink-400 hover:scale-[1.02]">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <div class="bg-gradient-to-br from-pink-500 to-rose-500 p-4 rounded-xl text-white shrink-0 group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas {{ $appointment->icon }} text-xl"></i>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="bg-pink-200 text-pink-800 px-3 py-1 rounded-full text-sm font-bold">
                                                        <i class="far fa-clock mr-1"></i>{{ $appointment->time }}
                                                    </span>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $appointment->service }}</h3>
                                                <div class="flex items-center text-gray-600">
                                                    <i class="fas fa-user-circle text-pink-500 mr-2"></i>
                                                    <p class="font-medium">{{ $appointment->client_name }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            @if($appointment->status == 'Completed')
                                                <span class="px-5 py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-lg">
                                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                                </span>
                                            @elseif($appointment->status == 'Pending')
                                                <span class="px-5 py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg">
                                                    <i class="fas fa-hourglass-half mr-1"></i> Menunggu
                                                </span>
                                                
                                                <form action="{{ route('pegawai.appointment.complete', $appointment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin layanan ini sudah selesai?');">
                                                    @csrf
                                                    <button type="submit" class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-6 py-2.5 text-sm rounded-xl hover:from-pink-600 hover:to-rose-600 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-pink-300">
                                                        <i class="fas fa-check mr-2"></i>Selesai
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl border-2 border-dashed border-pink-300">
                            <div class="inline-block bg-pink-100 p-6 rounded-full mb-4">
                                <i class="fas fa-calendar-check text-6xl text-pink-400"></i>
                            </div>
                            <p class="text-gray-600 text-lg font-medium">Tidak ada jadwal layanan untuk hari ini</p>
                            <p class="text-gray-500 text-sm mt-2">Nikmati waktu istirahat Anda! 😊</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Info Cepat --}}
                <div class="bg-white rounded-3xl shadow-2xl p-8 border-t-4 border-pink-500">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-3 rounded-xl mr-3">
                            <i class="fas fa-lightbulb text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Info Cepat</h2>
                    </div>
                    
                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 p-6 rounded-2xl mb-6 border border-pink-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-tasks text-pink-500 mr-2"></i>
                            Tugas Utama Pegawai
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="bg-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5 shrink-0">1</span>
                                <span class="text-gray-700">Laksanakan layanan sesuai jadwal</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5 shrink-0">2</span>
                                <span class="text-gray-700">Pastikan kualitas pelayanan terbaik</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5 shrink-0">3</span>
                                <span class="text-gray-700">Perbarui status layanan setelah selesai</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border border-purple-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-envelope text-purple-500 mr-2"></i>
                            Pesan dari Admin
                        </h3>
                        <blockquote class="border-l-4 border-purple-500 pl-4 italic text-gray-700 bg-white p-4 rounded-r-xl">
                            "Mohon cek ketersediaan produk sebelum memulai layanan yang membutuhkan stok."
                        </blockquote>
                    </div>
                </div>

                {{-- Tips Hari Ini --}}
                <div class="bg-gradient-to-br from-pink-500 via-rose-500 to-pink-600 rounded-3xl shadow-2xl p-8 text-white">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-star text-yellow-300 text-2xl mr-3"></i>
                        <h3 class="text-2xl font-bold">Tips Hari Ini</h3>
                    </div>
                    <p class="text-pink-100 leading-relaxed">
                        Senyum adalah aksesori terbaik! 😊 Berikan pelayanan terbaik dengan senyuman hangat kepada setiap pelanggan.
                    </p>
                </div>

                {{-- Performance Card --}}
                <div class="bg-white rounded-3xl shadow-2xl p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-line text-pink-500 mr-2"></i>
                        Performa Bulan Ini
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Layanan Selesai</span>
                                <span class="text-sm font-bold text-pink-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-pink-500 to-rose-500 h-3 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Rating Pelanggan</span>
                                <span class="text-sm font-bold text-pink-600">92%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .group:hover .fa-cut,
    .group:hover .fa-hand-sparkles,
    .group:hover .fa-spray-can {
        animation: float 2s ease-in-out infinite;
    }
</style>
@endsection