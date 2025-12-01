@extends('pegawai.app')

@section('title', 'Riwayat Layanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        
        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>

            <div class="relative z-10">
                <h1 class="text-4xl font-bold mb-2">📋 Riwayat Layanan</h1>
                <p class="text-pink-100 text-lg">Daftar layanan yang telah diselesaikan</p>
            </div>
        </div>

        {{-- Jika tidak ada riwayat --}}
        @if($history->count() === 0)
            <div class="bg-white rounded-3xl shadow-2xl p-16 text-center">
                <div class="mb-6">
                    <svg class="mx-auto h-24 w-24 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-gray-600 text-xl font-medium mb-2">Belum ada riwayat layanan</p>
                <p class="text-gray-500">Riwayat layanan yang diselesaikan akan muncul di sini</p>
            </div>
        @else

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($history as $item)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-pink-100">
                        
                        {{-- Status Header --}}
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b border-pink-200">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-sm">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Selesai
                                </span>
                                <span class="text-xs text-gray-600 font-medium">
                                    {{ $item->formatted_date }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6">
                            
                            {{-- Customer Info --}}
                            <div class="mb-4">
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-md">
                                        {{ strtoupper(substr($item->user->name ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-gray-800">
                                            {{ $item->user->name ?? 'Tanpa Nama' }}
                                        </p>
                                        <p class="text-xs text-gray-500">🧍‍♀️ Pelanggan</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Service Info --}}
                            <div class="bg-pink-50 border border-pink-200 rounded-2xl p-4 mb-4">
                                <p class="text-xs text-pink-600 uppercase tracking-wide font-semibold mb-1">Layanan</p>
                                <p class="text-base font-bold text-pink-700">
                                    {{ $item->service->name ?? '-' }}
                                </p>
                            </div>

                            {{-- Catatan --}}
                            @if($item->notes)
                                <div class="bg-purple-50 border border-purple-200 rounded-2xl p-4 mb-4">
                                    <p class="text-xs text-purple-700 font-semibold mb-1.5">💬 Catatan:</p>
                                    <p class="text-sm text-purple-900 leading-relaxed">
                                        {{ $item->notes }}
                                    </p>
                                </div>
                            @endif

                            {{-- Waktu & Tanggal --}}
                            <div class="border-t border-pink-100 pt-4 space-y-2.5">
                                <div class="flex items-center text-sm">
                                    <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Waktu</p>
                                        <p class="text-sm font-semibold text-gray-700">{{ $item->formatted_time }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal</p>
                                        <p class="text-sm font-semibold text-gray-700">{{ $item->formatted_date }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
</div>
@endsection