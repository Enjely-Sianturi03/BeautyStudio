@extends('layouts.admin')

@section('title', 'Tambah Tips / Artikel')
@section('page', 'Tambah Tips & Artikel')

@section('content')

<div class="bg-white p-6 rounded shadow border-l-4 border-pink-400 max-w-3xl">

    <h2 class="text-2xl font-bold mb-6 text-pink-700">Tambah Tips & Artikel</h2>

    {{-- Tampilkan error --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tipsartikel.store') }}" 
          method="POST" 
          enctype="multipart/form-data">

        @csrf

        {{-- JUDUL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" 
                   name="title" 
                   value="{{ old('title') }}"
                   class="w-full border rounded p-2 focus:ring focus:ring-pink-300" 
                   required>
        </div>

        {{-- KATEGORI --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" 
                    class="w-full border rounded p-2 focus:ring focus:ring-pink-300" 
                    required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Perawatan Rambut">Perawatan Rambut</option>
                <option value="Perawatan Wajah">Perawatan Wajah</option>
                <option value="Kesehatan Kulit">Kesehatan Kulit</option>
                <option value="Produk Rekomendasi">Produk Rekomendasi</option>
            </select>
        </div>

        {{-- TIPE --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipe Konten</label>
            <select name="type" 
                    class="w-full border rounded p-2 focus:ring focus:ring-pink-300" 
                    required>
                <option value="">-- Pilih Tipe --</option>
                <option value="article">Artikel</option>
                <option value="video">Video</option>
            </select>
        </div>

        {{-- LINK ARTIKEL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Link Artikel (Opsional)</label>
            <input type="text" 
                   name="link" 
                   value="{{ old('link') }}"
                   class="w-full border rounded p-2 focus:ring focus:ring-pink-300">
            <p class="text-sm text-gray-500">Isi link jika artikel ini berasal dari situs lain.</p>
        </div>

        {{-- KONTEN --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Konten Artikel</label>
            <textarea name="content" 
                      rows="6"
                      class="w-full border rounded p-2 focus:ring focus:ring-pink-300">{{ old('content') }}</textarea>
        </div>

        {{-- VIDEO URL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Video URL (Kosongkan jika artikel)</label>
            <input type="text" 
                   name="video_url" 
                   value="{{ old('video_url') }}"
                   class="w-full border rounded p-2 focus:ring focus:ring-pink-300">
        </div>

        {{-- THUMBNAIL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Thumbnail (Opsional)</label>
            
            <input type="file" 
                   name="thumbnail" 
                   id="thumbnailInput" 
                   class="w-full border rounded p-2">

            <img id="thumbnailPreview" 
                 class="mt-2 w-32 h-20 object-cover hidden rounded shadow" 
                 alt="Preview Thumbnail">
        </div>

        <button class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
            Simpan Artikel
        </button>

    </form>

</div>

<script>
    const input = document.getElementById('thumbnailInput');
    const preview = document.getElementById('thumbnailPreview');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        } else {
            preview.src = '';
            preview.classList.add('hidden');
        }
    });
</script>

@endsection
