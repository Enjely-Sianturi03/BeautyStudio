{{-- resources/views/employee/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="container mx-auto px-4 py-12 bg-pink-50 min-h-screen">
    {{-- HEADER --}}
    <header class="mb-8">
        <h1 class="text-4xl font-serif font-bold text-pink-800">
            Halo, {{ Auth::user()->name }}!
        </h1>
        <p class="text-pink-700 mt-2">
            Dashboard ini menampilkan jadwal, status layanan, dan informasi stok yang relevan untuk pegawai. Kerjakan layanan sesuai jadwal dan laporkan jika ada kendala.
        </p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- UTAMA: Jadwal Hari Ini --}}
        <main class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-serif font-semibold text-pink-700">📅 Jadwal Layanan Hari Ini</h2>
                <div class="text-sm text-pink-600">Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</div>
            </div>

            {{-- Gunakan $todayAppointments dari controller --}}
            @php
            // Jika variabel tidak ada atau kosong, pakai dummy (untuk debugging)
            if (!isset($todayAppointments) || (is_countable($todayAppointments) && count($todayAppointments) === 0)) {
                $todayAppointments = [
            (object)['id'=>1,'time'=>'10:00','client'=>'Salwa Halila','service'=>'Hair Cut & Wash','status'=>'Pending'],
            (object)['id'=>2,'time'=>'12:30','client'=>'Willy Armando','service'=>'Manicure & Pedicure','status'=>'Ongoing'],
            (object)['id'=>3,'time'=>'14:00','client'=>'Cindy Artika','service'=>'Coloring & Blow Dry','status'=>'Completed'],
                 ];
             }
            @endphp


            @if(count($todayAppointments) > 0)
                <div class="space-y-4">
                    @foreach($todayAppointments as $apt)
                        <article class="bg-white border border-pink-200 rounded-lg p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <div class="mb-3 sm:mb-0">
                                <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">{{ $apt->time }}</p>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $apt->service }}</h3>
                                <p class="text-sm text-gray-600">
                                    Pelanggan:
                                    <span class="font-semibold text-pink-700">{{ $apt->client }}</span>
                                </p>
                                {{-- Quick link ke riwayat pelanggan --}}
                                <p class="text-xs mt-1">
                                    <a href="{{ route('employee.customer.history', ['customer' => $apt->client ?? '']) }}" class="text-pink-600 hover:underline">Lihat riwayat pelanggan</a>
                                </p>
                            </div>

                            <div class="flex items-center space-x-3">
                                {{-- Status badge --}}
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    @if($apt->status == 'Completed') bg-green-100 text-green-800
                                    @elseif($apt->status == 'Ongoing') bg-pink-100 text-pink-800
                                    @elseif($apt->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $apt->status }}
                                </span>

                                {{-- Tombol aksi: mulai / selesai --}}
                                @if($apt->status == 'Pending')
                                    <form action="{{ route('employee.appointment.start', $apt->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-pink-500 text-white px-4 py-2 text-sm rounded-md hover:bg-pink-600 transition">
                                            Mulai
                                        </button>
                                    </form>
                                @elseif($apt->status == 'Ongoing')
                                    <form action="{{ route('employee.appointment.complete', $apt->id) }}" method="POST" onsubmit="return confirm('Tandai layanan ini sebagai selesai?');">
                                        @csrf
                                        {{-- jika route pakai PATCH, tambahkan @method('PATCH') --}}
                                        <button type="submit" class="bg-pink-600 text-white px-4 py-2 text-sm rounded-md hover:bg-pink-700 transition">
                                            Tandai Selesai
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-white border border-pink-200 rounded-lg">
                    <p class="text-pink-600 font-medium">Tidak ada jadwal hari ini.</p>
                </div>
            @endif
        </main>

        {{-- SIDEBAR: Info Cepat, Stok Produk, Notifikasi --}}
        <aside class="lg:col-span-1">
            {{-- Ringkasan tugas --}}
            <section class="bg-pink-100 p-6 rounded-lg shadow-sm border border-pink-200 mb-6">
                <h3 class="text-lg font-semibold text-pink-800 mb-2">Tugas Harian</h3>
                <ul class="text-gray-700 list-disc list-inside text-sm space-y-2">
                    <li>Laksanakan layanan sesuai jadwal dan SOP.</li>
                    <li>Laporkan selesai layanan melalui tombol 'Tandai Selesai'.</li>
                    <li>Cek ketersediaan produk sebelum memulai layanan.</li>
                </ul>
            </section>

            {{-- Stok produk rendah (ambil $lowStockProducts dari controller) --}}
            @php
                $lowStockProducts = $lowStockProducts ?? [
                    (object)['name'=>'Cat Rambut Pink','stock'=>2],
                    (object)['name'=>'Shampoo Silver','stock'=>1],
                ];
            @endphp

            <section class="bg-white p-4 rounded-lg shadow-sm border border-pink-200 mb-6">
                <h4 class="text-md font-semibold text-pink-700 mb-3">⚠️ Produk hampir habis</h4>
                @if(count($lowStockProducts) > 0)
                    <ul class="text-sm text-gray-700 space-y-2">
                        @foreach($lowStockProducts as $prod)
                            <li class="flex justify-between items-center">
                                <div>
                                    <div class="font-medium text-pink-800">{{ $prod->name }}</div>
                                    <div class="text-xs text-gray-500">Sisa: {{ $prod->stock }}</div>
                                </div>
                                <form action="{{ route('employee.request.restock') }}" method="POST" class="ml-3">
                                    @csrf
                                    <input type="hidden" name="product" value="{{ $prod->name }}">
                                    <button type="submit" class="text-sm px-3 py-1 rounded-md border border-pink-300 text-pink-700 hover:bg-pink-50">
                                        Minta Restock
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-600">Semua stok dalam keadaan aman.</p>
                @endif
            </section>

            {{-- Notifikasi / Pesan dari Admin --}}
            <section class="bg-pink-50 p-4 rounded-lg border border-pink-200">
                <h4 class="text-md font-semibold text-pink-700 mb-2">Pesan dari Admin</h4>
                <blockquote class="text-sm italic text-gray-700 border-l-4 border-pink-400 pl-3">
                    {{-- Ganti dengan dynamic message jika ada --}}
                    {{ $adminMessage ?? '"Cek stok produk sebelum memulai layanan yang membutuhkan material."' }}
                </blockquote>
            </section>
        </aside>
    </div>

    {{-- FOOTER: cepat akses --}}
    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('employee.customers') }}" class="block bg-white border border-pink-200 rounded-lg p-4 text-center shadow-sm hover:shadow-md">
            <div class="text-pink-700 font-semibold">Data Pelanggan</div>
            <div class="text-xs text-gray-500">Lihat & cari riwayat pelanggan</div>
        </a>

        <a href="{{ route('employee.products') }}" class="block bg-white border border-pink-200 rounded-lg p-4 text-center shadow-sm hover:shadow-md">
            <div class="text-pink-700 font-semibold">Stok Produk</div>
            <div class="text-xs text-gray-500">Cek ketersediaan dan minta restock</div>
        </a>

        <a href="{{ route('employee.reports') }}" class="block bg-white border border-pink-200 rounded-lg p-4 text-center shadow-sm hover:shadow-md">
            <div class="text-pink-700 font-semibold">Riwayat Layanan</div>
            <div class="text-xs text-gray-500">Lihat layanan yang sudah selesai</div>
        </a>
    </div>
</div>
@endsection
