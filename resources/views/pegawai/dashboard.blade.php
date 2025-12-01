@extends('pegawai.app')

@section('title', 'Pegawai Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">

        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>

            <div class="relative z-10 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold mb-2">✨ Halo, {{ Auth::user()->name }}!</h1>
                    <p class="text-pink-100 text-lg">Semangat melayani dengan sepenuh hati hari ini! 💖</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/30 text-center">
                    <p class="text-sm text-pink-100">Hari Ini</p>
                    <p class="text-2xl font-bold">{{ date('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-pink-500">
                <p class="text-gray-500 text-sm font-medium">Total Hari Ini</p>
                <h3 class="text-3xl font-bold text-pink-600 mt-1">{{ $appointments->count() }}</h3>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-rose-500">
                <p class="text-gray-500 text-sm font-medium">Selesai</p>
                <h3 class="text-3xl font-bold text-rose-600 mt-1">{{ $appointments->where('status','completed')->count() }}</h3>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm font-medium">Menunggu</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-1">{{ $appointments->where('status','pending')->count() }}</h3>
            </div>
        </div>

        {{-- Jadwal Hari Ini --}}
        <div class="bg-white rounded-3xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Jadwal Layanan Hari Ini</h2>

            @if($appointments->count() > 0)
                <div class="space-y-4">

                    @foreach($appointments as $appointment)
                        <div class="bg-pink-50 border border-pink-200 rounded-2xl p-5 shadow hover:shadow-md transition">

                            <div class="flex items-center justify-between flex-wrap gap-3">

                                {{-- Info Pelanggan & Layanan --}}
                                <div>
                                    <h3 class="text-xl font-bold text-pink-600">
                                        {{ $appointment->service->nama ?? 'Layanan' }}
                                    </h3>

                                    <p class="text-gray-600">
                                        🧍‍♀️ {{ $appointment->user->name }}  
                                        —  
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                    </p>
                                </div>

                                {{-- Status + Tombol --}}
                                <div class="flex items-center gap-3">
                                    @if($appointment->status == 'completed')
                                        <span class="px-3 py-1 bg-blue-200 text-blue-700 rounded-full text-sm">Selesai</span>

                                    @elseif($appointment->status == 'pending')
                                        <span class="px-3 py-1 bg-yellow-200 text-yellow-700 rounded-full text-sm">Menunggu</span>

                                        <form action="{{ route('pegawai.appointment.complete', $appointment->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah layanan ini sudah selesai?');">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @elseif($appointment->status == 'confirmed')
                                        <span class="px-3 py-1 bg-green-200 text-green-700 rounded-full text-sm">Dikonfirmasi</span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                <p class="text-center text-gray-500 py-16">
                    Tidak ada jadwal layanan hari ini.
                </p>
            @endif

        </div>
    </div>
</div>
@endsection
