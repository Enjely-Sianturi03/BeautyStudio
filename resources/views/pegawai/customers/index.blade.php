@extends('layouts.app')

@section('title','Data Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-10 bg-pink-50 min-h-screen">
    <h1 class="text-3xl font-serif font-bold text-pink-800 mb-4">Data Pelanggan</h1>
    <p class="text-pink-700 mb-6">Cari dan lihat riwayat pelanggan untuk membantu layanan yang lebih personal.</p>

    <div class="bg-white border border-pink-200 rounded-lg p-4 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <form method="GET" action="{{ route('employee.customers') }}" class="flex space-x-2">
                <input name="q" type="text" placeholder="Cari nama / telepon" value="{{ request('q') }}"
                    class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-pink-200">
                <button class="px-4 py-2 bg-pink-500 text-white rounded-md">Cari</button>
            </form>
            <div class="text-sm text-gray-500">Total: {{ $customers->total() ?? 0 }}</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-pink-700">
                        <th class="py-2">Nama</th>
                        <th class="py-2">Telepon</th>
                        <th class="py-2">Terakhir Dilayani</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr class="border-t">
                        <td class="py-3">{{ $c->name }}</td>
                        <td class="py-3">{{ $c->phone }}</td>
                        <td class="py-3 text-gray-600 text-sm">{{ optional($c->appointments()->latest()->first())->date ?? '-' }}</td>
                        <td class="py-3">
                            <a href="{{ route('employee.customer.history', $c->id) }}" class="text-pink-700 hover:underline">Lihat Riwayat</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-6 text-center text-gray-500">Belum ada pelanggan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
