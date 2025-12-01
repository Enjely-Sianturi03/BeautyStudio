@extends('layouts.app')

@section('title','Stok Produk')

@section('content')
<div class="container mx-auto px-4 py-10 bg-pink-50 min-h-screen">
    <h1 class="text-3xl font-serif font-bold text-pink-800 mb-4">Stok Produk</h1>
    <p class="text-pink-700 mb-6">Pantau stok produk dan ajukan permintaan restock saat diperlukan.</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-pink-200 rounded-lg p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-pink-700">
                        <th class="py-2">Produk</th>
                        <th class="py-2">Stok</th>
                        <th class="py-2">Keterangan</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr class="border-t">
                        <td class="py-3 font-medium text-pink-800">{{ $p->name }}</td>
                        <td class="py-3">{{ $p->stock ?? 0 }}</td>
                        <td class="py-3 text-sm text-gray-600">{{ $p->note ?? '-' }}</td>
                        <td class="py-3">
                            <form action="{{ route('employee.request.restock') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product" value="{{ $p->name }}">
                                <button type="submit" class="px-3 py-1 text-sm border border-pink-300 rounded text-pink-700 hover:bg-pink-50">Minta Restock</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-6 text-center text-gray-500">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
