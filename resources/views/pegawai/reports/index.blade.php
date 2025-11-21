@extends('layouts.app')

@section('title','Riwayat Layanan')

@section('content')
<div class="container mx-auto px-4 py-10 bg-pink-50 min-h-screen">
    <h1 class="text-3xl font-serif font-bold text-pink-800 mb-4">Riwayat Layanan</h1>
    <p class="text-pink-700 mb-6">Daftar layanan yang sudah Anda kerjakan (terbaru di atas).</p>

    <div class="bg-white border border-pink-200 rounded-lg p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-pink-700">
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Waktu</th>
                        <th class="py-2">Pelanggan</th>
                        <th class="py-2">Layanan</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                    <tr class="border-t">
                        <td class="py-3">{{ \Carbon\Carbon::parse($h->date)->format('d M Y') }}</td>
                        <td class="py-3">{{ $h->time }}</td>
                        <td class="py-3">{{ optional($h->customer)->name ?? $h->customer_name }}</td>
                        <td class="py-3">{{ $h->service_name ?? $h->service }}</td>
                        <td class="py-3">{{ $h->total ?? '-' }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded text-xs
                                @if($h->status == 'Completed') bg-green-100 text-green-800
                                @elseif($h->status == 'Pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">{{ $h->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada riwayat layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $history->links() }}
        </div>
    </div>
</div>
@endsection
