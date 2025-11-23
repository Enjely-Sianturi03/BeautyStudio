@extends('layouts.admin')

@section('title', 'Transaksi')
@section('page', 'Transaksi')

@section('content')

{{-- ========================= --}}
{{-- FORM INPUT TRANSAKSI --}}
{{-- ========================= --}}
<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">

    <h2 class="text-lg font-bold mb-4">Tambah Transaksi Manual</h2>

    <form method="POST" action="{{ route('admin.transaksi.store') }}" class="space-y-3">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

            {{-- PILIH PELANGGAN --}}
            <select name="pelanggan_id" class="p-2 border rounded" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>

            {{-- PILIH JADWAL OPSIONAL --}}
            <select name="jadwal_id" class="p-2 border rounded">
                <option value="">Tautkan Jadwal (Opsional)</option>
                @foreach($jadwals as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->mulai_at->format('d/m H:i') }}
                        — {{ $j->pelanggan->nama ?? '-' }}
                        — {{ $j->layanan->nama ?? '-' }}
                    </option>
                @endforeach
            </select>

            {{-- METODE --}}
            <select name="metode" class="p-2 border rounded">
                <option value="cash">Cash</option>
                <option value="qris">QRIS</option>
                <option value="transfer">Transfer</option>
            </select>

            <button class="bg-pink-500 text-white rounded px-4">
                Simpan Transaksi
            </button>
        </div>

        {{-- ITEM LAYANAN --}}
        <div id="items" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
            <div class="p-3 border rounded">
                <label class="block text-sm mb-1">Layanan</label>
                <select name="items[0][layanan_id]" class="p-2 border rounded w-full">
                    @foreach($layanans as $l)
                        <option value="{{ $l->id }}">
                            {{ $l->nama }} — Rp {{ number_format($l->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>

                <label class="block text-sm mt-2 mb-1">Qty</label>
                <input type="number" name="items[0][qty]" value="1" class="p-2 border rounded w-full">
            </div>
        </div>
    </form>

</div>



{{-- ========================= --}}
{{-- TABEL APPOINTMENT --}}
{{-- ========================= --}}
<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">

    <h2 class="text-lg font-bold mb-4">Daftar Appointment</h2>

    <table class="w-full">
        <thead class="bg-pink-200">
            <tr>
                <th class="text-left py-2 px-3">Tanggal</th>
                <th class="text-left py-2 px-3">Pelanggan</th>
                <th class="text-left py-2 px-3">Metode</th>
                <th class="text-left py-2 px-3">Status</th>
                <th class="text-left py-2 px-3">Service</th>
                <th class="text-left py-2 px-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($appointments as $a)
            <tr class="border-b hover:bg-pink-50">

                {{-- TANGGAL --}}
                <td class="py-2 px-3">
                    {{ \Carbon\Carbon::parse($a->appointment_date)->format('d/m/Y') }}
                </td>

                {{-- PELANGGAN --}}
                <td class="py-2 px-3">
                    {{ $a->name ?? ($a->user->name ?? '-') }}
                </td>

                {{-- METODE --}}
                <td class="py-2 px-3 uppercase">
                    {{ $a->payment_method ?? '-' }}
                </td>

                {{-- STATUS --}}
                <td class="py-2 px-3">
                    @php
                        $status = [
                            'pending'   => ['bg-yellow-100','text-yellow-700','PENDING'],
                            'confirmed' => ['bg-blue-100','text-blue-700','CONFIRMED'],
                            'cancelled' => ['bg-red-100','text-red-700','CANCELLED'],
                            'completed' => ['bg-green-100','text-green-700','COMPLETED'],
                        ];
                    @endphp

                    @if(isset($status[$a->status]))
                        <span class="{{ $status[$a->status][0] }} {{ $status[$a->status][1] }} px-2 py-1 rounded text-xs font-bold">
                            {{ $status[$a->status][2] }}
                        </span>
                    @else
                        <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-xs font-bold">
                            UNKNOWN
                        </span>
                    @endif
                </td>

                {{-- LAYANAN --}}
                <td class="py-2 px-3">
                    {{ $a->service->nama ?? '-' }}
                </td>

                {{-- AKSI --}}
                <td class="py-2 px-3">
                    <a href="{{ route('admin.transaksi.show', $a->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        Detail
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $appointments->links() }}
    </div>

</div>

@endsection
