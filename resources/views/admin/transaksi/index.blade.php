@extends('layouts.admin')

@section('title', 'Transaksi')
@section('page', 'Transaksi')

@section('content')

<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">
    <h2 class="text-lg font-bold mb-4">Tambah Transaksi Manual</h2>

    <form method="POST" action="{{ route('admin.transaksi.store.manual') }}">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

        {{-- PILIH CUSTOMER --}}
        <select name="user_id" class="p-2 border rounded" required>
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>

        {{-- PILIH LAYANAN --}}
        <select name="service_id" class="p-2 border rounded" required>
            @foreach($layanans as $l)
                <option value="{{ $l->id }}">
                    {{ $l->nama }} — Rp {{ number_format($l->harga,0,',','.') }}
                </option>
            @endforeach
        </select>

        {{-- TANGGAL --}}
        <input type="date" name="appointment_date" class="p-2 border rounded" required>

        {{-- JAM --}}
        <input type="time" name="appointment_time" class="p-2 border rounded" required>

        {{-- METODE PEMBAYARAN --}}
        <select name="payment_method" class="p-2 border rounded">
            <option value="cash">Cash</option>
            <option value="qris">QRIS</option>
            <option value="transfer">Transfer</option>
        </select>

        <button class="bg-pink-500 text-white rounded px-4">
            Simpan Transaksi
        </button>

    </div>
</form>

</div>


{{-- TABLE APPOINTMENTS --}}
<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">

    <h2 class="text-lg font-bold mb-4">Daftar Appointment</h2>

    <table class="w-full">
        <thead class="bg-pink-200">
            <tr>
                <th class="py-2 px-3 text-left">Tanggal</th>
                <th class="py-2 px-3 text-left">Pelanggan</th>
                <th class="py-2 px-3 text-left">Metode</th>
                <th class="py-2 px-3 text-left">Status</th>
                <th class="py-2 px-3 text-left">Service</th>
                <th class="py-2 px-3 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($appointments as $a)
            <tr class="border-b hover:bg-pink-50">

                <td class="py-2 px-3">
                    {{ \Carbon\Carbon::parse($a->appointment_date)->format('d/m/Y') }}
                </td>

                <td class="py-2 px-3">
                    {{ $a->user->name ?? '-' }}
                </td>

                <td class="py-2 px-3 uppercase">
                    {{ $a->payment_method ?? '-' }}
                </td>

                <td class="py-2 px-3">
                    @php
                        $status = [
                            'pending'   => ['bg-yellow-100','text-yellow-700','PENDING'],
                            'confirmed' => ['bg-blue-100','text-blue-700','CONFIRMED'],
                            'cancelled' => ['bg-red-100','text-red-700','CANCELLED'],
                            'completed' => ['bg-green-100','text-green-700','COMPLETED'],
                        ];
                    @endphp

                    <span class="{{ $status[$a->status][0] }} {{ $status[$a->status][1] }} px-2 py-1 rounded text-xs font-bold">
                        {{ $status[$a->status][2] }}
                    </span>

                </td>

                <td class="py-2 px-3">
                    {{ $a->service->nama ?? '-' }}
                </td>

                <td class="py-2 px-3">
                    @php
                        $trx = \App\Models\Transaksi::where('user_id', $a->user_id)
                            ->where('service_id', $a->service_id)
                            ->where('date', $a->appointment_date)
                            ->first();
                    @endphp

                    <a href="{{ route('admin.transaksi.show', $a->id) }}"
                    class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        Detail
                    </a>
                    <form action="{{ route('admin.appointments.destroy', $a->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');"
                        class="inline-block ml-1">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                            Hapus
                        </button>
                    </form>
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
