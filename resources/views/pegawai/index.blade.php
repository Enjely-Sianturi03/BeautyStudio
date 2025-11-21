@extends('layouts.app') 

@section('title', 'Pegawai Dashboard')

@section('content')
<div class="container mx-auto px-4 py-12 bg-pink-50 min-h-screen">
    <header class="mb-10">
        <h1 class="text-4xl font-serif font-bold text-pink-800">
            Halo, {{ Auth::user()->name }}!
        </h1>
        <p class="text-pink-700 mt-2">
            Berikut adalah jadwal layanan Anda hari ini. Fokus pada pelaksanaan layanan yang optimal.
        </p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-serif font-semibold mb-6 border-b pb-2 text-pink-700">
                📅 Jadwal Layanan Hari Ini
            </h2>

            {{-- Asumsikan data $appointments berisi jadwal layanan hari ini --}}
            @php
                // Data dummy untuk ilustrasi
                $appointments = [
                    (object)['id' => 1, 'time' => '10:00', 'client_name' => 'Salwa Halila', 'service' => 'Hair Cut & Wash', 'status' => 'Pending'],
                    (object)['id' => 2, 'time' => '12:30', 'client_name' => 'Willy Armando', 'service' => 'Manicure & Pedicure', 'status' => 'Pending'],
                    (object)['id' => 3, 'time' => '14:00', 'client_name' => 'Cindy Artika', 'service' => 'Coloring & Blow Dry', 'status' => 'Completed'],
                ];
            @endphp

            @if(count($appointments) > 0)
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        <div class="bg-white border border-pink-200 rounded-lg p-5 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center transition duration-300 hover:shadow-md hover:border-pink-300">
                            <div class="mb-3 sm:mb-0">
                                <p class="text-xs font-semibold uppercase tracking-wider text-pink-500">
                                    {{ $appointment->time }}
                                </p>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $appointment->service }}
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Pelanggan:
                                    <span class="font-semibold text-pink-700">
                                        {{ $appointment->client_name }}
                                    </span>
                                </p>
                            </div>

                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 text-sm font-medium rounded-full 
                                    @if($appointment->status == 'Completed') bg-green-100 text-green-800 
                                    @elseif($appointment->status == 'Pending') bg-yellow-100 text-yellow-800 
                                    @else bg-gray-100 text-gray-800 
                                    @endif">
                                    {{ $appointment->status }}
                                </span>

                                @if($appointment->status == 'Pending')
                                    <form action="{{ route('employee.appointment.complete', $appointment->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin layanan ini sudah selesai?');">
                                        @csrf
                                        {{-- @method('PATCH')  // bisa diaktifkan jika route-nya menerima PATCH --}}
                                        <button type="submit"
                                            class="bg-pink-500 text-white px-4 py-2 text-sm rounded-md hover:bg-pink-600 transition font-medium focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-70">
                                            Selesai
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-pink-50 rounded-lg border border-pink-200">
                    <p class="text-pink-700">Tidak ada jadwal layanan yang ditugaskan untuk hari ini.</p>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            <h2 class="text-2xl font-serif font-semibold mb-6 border-b pb-2 text-pink-700">
                💡 Info Cepat
            </h2>
            
            <div class="bg-pink-50 p-6 rounded-lg shadow-sm mb-6 border border-pink-200">
                <h3 class="text-lg font-semibold mb-3 text-pink-800">Tugas Utama Pegawai</h3>
                <ul class="text-gray-700 space-y-2 list-disc list-inside text-sm">
                    <li>Laksanakan layanan sesuai jadwal.</li>
                    <li>Pastikan kualitas pelayanan terbaik.</li>
                    <li>Perbarui status layanan menjadi 'selesai' setelah selesai.</li>
                </ul>
            </div>

            <div class="bg-pink-50 p-6 rounded-lg shadow-sm border border-pink-200">
                <h3 class="text-lg font-semibold mb-3 text-pink-800">Pesan dari Admin</h3>
                <blockquote class="border-l-4 border-pink-400 pl-4 italic text-gray-700 text-sm">
                    "Mohon cek ketersediaan produk sebelum memulai layanan yang membutuhkan stok."
                </blockquote>
            </div>
        </div>
    </div>
</div>
@endsection
