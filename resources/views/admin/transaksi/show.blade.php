@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page', 'Detail Transaksi')

@section('content')

<div class="bg-white p-6 shadow rounded border-l-4 border-pink-400">

    <h2 class="text-xl font-bold mb-6">Detail Transaksi</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- ===================== --}}
        {{-- KOLOM KIRI --}}
        {{-- ===================== --}}
        <div>
            <p class="mb-3">
                <strong>Tanggal:</strong><br>
                {{ \Carbon\Carbon::parse($transaksi->appointment_date)->format('d/m/Y') }}
            </p>

            <p class="mb-3">
                <strong>Pelanggan:</strong><br>
                {{ $transaksi->pelanggan->nama ?? '-' }}
            </p>

            <p class="mb-3">
                <strong>Metode Pembayaran:</strong><br>
                {{ strtoupper($transaksi->payment_method ?? '-') }}
            </p>

            <p class="mb-3">
                <strong>Status:</strong><br>
                <span class="px-3 py-1 rounded text-sm font-bold
                    @if($transaksi->status == 'pending') bg-yellow-100 text-yellow-700
                    @elseif($transaksi->status == 'confirmed') bg-blue-100 text-blue-700
                    @elseif($transaksi->status == 'cancelled') bg-red-100 text-red-700
                    @elseif($transaksi->status == 'completed') bg-green-100 text-green-700
                    @else bg-gray-200 text-gray-700 @endif">
                    {{ strtoupper($transaksi->status) }}
                </span>
            </p>
        </div>

        {{-- ===================== --}}
        {{-- KOLOM KANAN --}}
        {{-- ===================== --}}
        <div>
            <p class="mb-3">
                <strong>Layanan:</strong><br>
                {{ $transaksi->service->nama ?? '-' }}
            </p>

            <p class="mb-1">
                <strong>Bukti Pembayaran:</strong>
            </p>

            @if($transaksi->payment_proof)
                <img src="{{ asset('storage/' . $transaksi->payment_proof) }}"
                     alt="Bukti Pembayaran"
                     class="w-full max-w-md rounded shadow border">
            @else
                <p class="text-gray-500 italic">Tidak ada bukti pembayaran</p>
            @endif
        </div>

    </div>

    {{-- ================================================= --}}
    {{-- TOMBOL AKSI (CONFIRM / CANCEL) --}}
    {{-- ================================================= --}}
    <div class="mt-6 flex gap-3 items-center">

        @if($transaksi->status == 'pending')

            {{-- TOMBOL CONFIRM --}}
            <form action="{{ route('admin.transaksi.confirm', $transaksi->id) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin CONFIRM transaksi ini?');">
                @csrf
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">
                    Confirm
                </button>
            </form>

            {{-- TOMBOL CANCEL --}}
            <form action="{{ route('admin.transaksi.cancel', $transaksi->id) }}"
                  method="POST"
                  onsubmit="return confirm('Batalkan transaksi ini?');">
                @csrf
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">
                    Cancel
                </button>
            </form>

        @endif

        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('admin.transaksi.index') }}"
           class="ml-auto bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">
            Kembali
        </a>

    </div>

</div>

@endsection
