@extends('pegawai.app')

@section('title', 'Jadwal Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 py-10">
    <div class="max-w-5xl mx-auto px-4">

        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 text-white p-8 rounded-3xl shadow-xl mb-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-52 h-52 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>

            <h1 class="text-4xl font-bold relative z-10">📅 Jadwal Layanan Anda</h1>
            <p class="text-pink-100 mt-2 text-lg relative z-10">Berikut adalah semua jadwal layanan yang sudah ditugaskan kepada Anda.</p>
        </div>

        <!-- Jadwal -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Jadwal</h2>

            @if($schedules->count() > 0)
                <div class="space-y-5">

                    @foreach($schedules as $schedule)
                        <div class="bg-pink-50 border border-pink-200 rounded-2xl p-5 shadow hover:shadow-md transition relative">

                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">

                                <!-- Info Jadwal -->
                                <div>
                                    <h3 class="text-xl font-bold text-pink-600">
                                        {{ $schedule->service->nama ?? 'Layanan' }}
                                    </h3>

                                    <p class="text-gray-700 mt-1">
                                        🧍‍♀️ <span class="font-semibold">{{ $schedule->user->name }}</span>
                                    </p>

                                    <p class="text-gray-600 text-sm">
                                        ✉️ {{ $schedule->user->email }}
                                    </p>
                                </div>

                                <!-- Waktu -->
                                <div class="text-right md:text-center">
                                    <p class="text-gray-700 font-semibold">
                                        {{ \Carbon\Carbon::parse($schedule->appointment_date)->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="text-gray-600 text-lg font-bold">
                                        {{ \Carbon\Carbon::parse($schedule->appointment_time)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mt-4">
                                @if($schedule->status === 'pending')
                                    <span class="px-3 py-1 text-sm bg-yellow-200 text-yellow-700 rounded-full">Menunggu</span>
                                @elseif($schedule->status === 'confirmed')
                                    <span class="px-3 py-1 text-sm bg-green-200 text-green-700 rounded-full">Dikonfirmasi</span>
                                @elseif($schedule->status === 'completed')
                                    <span class="px-3 py-1 text-sm bg-blue-200 text-blue-700 rounded-full">Selesai</span>
                                @else
                                    <span class="px-3 py-1 text-sm bg-gray-300 text-gray-700 rounded-full">Dibatalkan</span>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>

            @else
                <div class="text-center py-20 text-gray-500">
                    <p class="text-xl">Tidak ada jadwal untuk Anda saat ini.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
