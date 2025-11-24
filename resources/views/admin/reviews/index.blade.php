@extends('layouts.admin')

@section('title', 'Manajemen Review')
@section('page', 'Manajemen Review')

@section('content')

<div class="bg-white shadow rounded-lg p-6 border-l-4 border-pink-400">

    <h2 class="text-2xl font-bold text-pink-700 mb-4">Daftar Review Pelanggan</h2>

    <!-- Jika ada pesan berhasil -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABEL REVIEW -->
    <div class="overflow-x-auto mt-4">
        <table class="w-full border-collapse bg-white">
            <thead>
                <tr class="bg-pink-200 text-pink-900 text-left">
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Rating</th>
                    <th class="p-3 border">Pesan</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews as $review)
                    <tr class="border-b hover:bg-pink-50">
                        <td class="p-3 border">{{ $review->name }}</td>

                        <td class="p-3 border">
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <span class="text-yellow-500">★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                        </td>

                        <td class="p-3 border">{{ $review->message }}</td>

                        <td class="p-3 border">
                            @if($review->is_approved)
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-sm font-semibold">
                                    Disetujui
                                </span>
                            @else
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-sm font-semibold">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td class="p-3 border text-center space-x-2">

                            {{-- Tombol Setujui --}}
                            @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Approve
                                </button>
                            </form>
                            @endif

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus review ini?');"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            Belum ada review.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</div>

@endsection
