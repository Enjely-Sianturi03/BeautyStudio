@extends('layouts.admin')
@section('title','Jadwal Layanan')
@section('page','Jadwal Layanan')

@section('content')

<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">
    <h2 class="text-2xl font-bold mb-4 text-pink-600">Jadwal Layanan Masuk</h2>
    @if ($errors->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            {{ $errors->first('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="w-full border-collapse rounded overflow-hidden">
        <thead class="bg-pink-200">
            <tr>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Pelanggan</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Layanan</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Tanggal</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Jam Mulai</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Jam Selesai</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Status</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-700">Staf</th>
                <th class="py-3 px-4 text-center font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($appointments as $a)
            <tr class="border-b hover:bg-pink-50 transition">
                <td class="py-3 px-4">
                    <div class="font-semibold text-gray-800">{{ $a->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $a->user->email }}</div>
                </td>

                <td class="py-3 px-4">
                    {{ $a->service->nama }}
                </td>

                <td class="py-3 px-4">
                    {{ \Carbon\Carbon::parse($a->appointment_date)->translatedFormat('d F Y') }}
                </td>

                <td class="py-3 px-4">
                    {{ \Carbon\Carbon::parse($a->appointment_time)->format('H:i') }}
                </td>

                <td class="py-3 px-4">
                    {{ $a->end_time }}
                </td>

                <td class="py-3 px-4">
                    @if($a->status === 'pending')
                        <span class="px-3 py-1 text-xs bg-yellow-200 text-yellow-700 rounded-full">Pending</span>
                    @elseif($a->status === 'confirmed')
                        <span class="px-3 py-1 text-xs bg-green-200 text-green-700 rounded-full">Dikonfirmasi</span>
                    @elseif($a->status === 'completed')
                        <span class="px-3 py-1 text-xs bg-blue-200 text-blue-700 rounded-full">Selesai</span>
                    @else
                        <span class="px-3 py-1 text-xs bg-red-200 text-red-700 rounded-full">Dibatalkan</span>
                    @endif
                </td>

                <td class="py-3 px-4">
                <form action="{{ route('admin.jadwal.update', $a->id) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PUT')

                    <select name="stylist_id" class="border rounded p-2 w-full">
                        <option value="">Pilih Staf</option>
                        @foreach($staff as $s)
                            <option value="{{ $s->id }}" {{ $a->stylist_id == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="bg-pink-500 text-white px-3 py-1 rounded hover:bg-pink-600 transition">
                        Simpan
                    </button>

                    @error('stylist_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </form>
                </td>

                <td class="py-3 px-4 text-center">
                    <div class="flex items-center justify-center gap-3">

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.jadwal.destroy', $a->id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7" class="py-6 text-center text-gray-500">
                    Belum ada jadwal booking.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
