@extends('layouts.admin')

@section('title', 'Detail Appointment')
@section('page', 'Detail Appointment')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-8 border border-gray-200">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Detail Appointment
        </h2>

        <a href="{{ route('admin.jadwal.index') }}" 
           class="text-sm text-gray-600 hover:text-gray-900 underline">
            ← Kembali
        </a>
    </div>

    <!-- Informasi Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="space-y-3">
            <p class="text-gray-700"><span class="font-semibold">Pelanggan:</span> {{ $appointment->user->name }}</p>
            <p class="text-gray-700"><span class="font-semibold">Layanan:</span> {{ $appointment->service->name }}</p>
            <p class="text-gray-700"><span class="font-semibold">Tanggal:</span> {{ $appointment->date }}</p>
            <p class="text-gray-700"><span class="font-semibold">Jam:</span> {{ $appointment->time }}</p>
        </div>

        <div class="space-y-3">
            <p class="text-gray-700"><span class="font-semibold">Status:</span> 
                <span class="px-3 py-1 rounded-full text-white 
                    @if($appointment->status == 'pending') bg-yellow-500
                    @elseif($appointment->status == 'confirmed') bg-green-600
                    @else bg-gray-500 @endif">
                    {{ ucfirst($appointment->status) }}
                </span>
            </p>

            @if ($appointment->staff)
                <p class="text-gray-700"><span class="font-semibold">Staf yang Ditunjuk:</span> {{ $appointment->staff->name }}</p>
            @else
                <p class="text-gray-500 italic">Belum ada staf yang ditunjuk.</p>
            @endif
        </div>

    </div>

    <hr class="my-8">

    <!-- Pilih Staff -->
    <h3 class="text-xl font-semibold text-gray-800 mb-4">
        Pilih Staf
    </h3>

    <form action="{{ route('admin.jadwal.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <select name="stylist_id" class="border rounded p-2 w-full">
            <option value="">Pilih Staf</option>
            @foreach($staff as $s)
                <option value="{{ $s->id }}" {{ $appointment->stylist_id == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>

        <button class="bg-pink-500 text-white px-3 py-1 rounded hover:bg-pink-600 mt-3">
            Simpan
        </button>
    </form>


</div>
@endsection
