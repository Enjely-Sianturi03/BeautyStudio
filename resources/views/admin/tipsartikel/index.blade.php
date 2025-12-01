@extends('layouts.admin') 
@section('title', 'Manajemen Tips & Artikel')
@section('page', 'Manajemen Tips & Artikel')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-pink-700">Daftar Tips & Artikel</h2>

        <a href="{{ route('admin.tipsartikel.create') }}"
           class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 font-semibold shadow">
            + Tambah Tips Baru
        </a>
    </div>

    <!-- Jika kosong -->
    @if($tips->count() == 0)
        <div class="text-center py-10 text-gray-600">
            <p class="text-lg font-semibold">Belum ada tips/artikel yang dibuat.</p>
        </div>
    @else

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-pink-100 text-pink-800">
                <tr>
                    <th class="p-3 border">Thumbnail</th>
                    <th class="p-3 border">Judul</th>
                    <th class="p-3 border">Kategori</th>
                    <th class="p-3 border">Tipe</th>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tips as $tip)
                <tr class="hover:bg-pink-50">

                    <!-- Thumbnail -->
                    <td class="p-3 border">
                        @if($tip->type == 'article')
                            <img src="{{ asset('storage/' . $tip->thumbnail) }}" 
                                 class="w-20 h-14 object-cover rounded shadow">
                        @else
                            <iframe src="{{ $tip->video_url }}" 
                                    class="w-20 h-14 rounded"
                                    frameborder="0"></iframe>
                        @endif
                    </td>

                    <!-- Title -->
                    <td class="p-3 border font-semibold text-gray-700">
                        {{ Str::limit($tip->title, 40) }}
                    </td>

                    <!-- Category -->
                    <td class="p-3 border capitalize">
                        {{ $tip->category }}
                    </td>

                    <!-- Type -->
                    <td class="p-3 border">
                        @if($tip->type == 'article')
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-semibold">Artikel</span>
                        @else
                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-semibold">Video</span>
                        @endif
                    </td>

                    <!-- Created At -->
                    <td class="p-3 border text-gray-600 text-sm">
                        {{ $tip->created_at->format('d M Y') }}
                    </td>

                    <!-- Actions -->
                    <td class="p-3 border text-center">

                        <a href="{{ route('admin.tipsartikel.edit', $tip->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded mr-2">
                           Edit
                        </a>

                        <form action="{{ route('admin.tipsartikel.destroy', $tip->id) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">
                                Hapus
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        {{ $tips->links() }}
    </div>

    @endif
</div>

@endsection
