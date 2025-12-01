@extends('layouts.admin')

@section('title', 'Edit Tips / Artikel')
@section('page', 'Edit Tips & Artikel')

@section('content')

<div class="bg-white p-6 rounded shadow border-l-4 border-blue-400 max-w-3xl">

    <h2 class="text-2xl font-bold mb-6 text-blue-700">Edit Tips & Artikel</h2>

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

    <form action="{{ route('admin.tipsartikel.update', $tip->id) }}" 
          method="POST" 
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- JUDUL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" 
                   name="title"
                   value="{{ old('title', $tip->title) }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- KATEGORI --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" class="w-full border rounded p-2">
                <option value="Perawatan Rambut" {{ $tip->category == 'Perawatan Rambut' ? 'selected' : '' }}>Perawatan Rambut</option>
                <option value="Perawatan Wajah" {{ $tip->category == 'Perawatan Wajah' ? 'selected' : '' }}>Perawatan Wajah</option>
                <option value="Kesehatan Kulit" {{ $tip->category == 'Kesehatan Kulit' ? 'selected' : '' }}>Kesehatan Kulit</option>
                <option value="Produk Rekomendasi" {{ $tip->category == 'Produk Rekomendasi' ? 'selected' : '' }}>Produk Rekomendasi</option>
            </select>
        </div>

        {{-- TIPE --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipe Konten</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="article" {{ $tip->type == 'article' ? 'selected' : '' }}>Artikel</option>
                <option value="video" {{ $tip->type == 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>

        {{-- LINK ARTIKEL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Link Artikel (opsional)</label>
            <input type="text" 
                   name="link"
                   value="{{ old('link', $tip->link) }}"
                   class="w-full border rounded p-2"
                   placeholder="https://contoh.com/artikel">
            <p class="text-sm text-gray-500">Isi jika konten artikel berasal dari situs lain.</p>
        </div>

        {{-- KONTEN --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Konten Artikel</label>
            <textarea name="content"
                      rows="6"
                      class="w-full border rounded p-2">{{ old('content', $tip->content) }}</textarea>
        </div>

        {{-- VIDEO URL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Video URL</label>
            <input type="text" 
                   name="video_url"
                   value="{{ old('video_url', $tip->video_url) }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- THUMBNAIL --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Thumbnail (Opsional)</label>

            @if($tip->thumbnail)
                <img src="{{ asset('storage/' . $tip->thumbnail) }}" 
                     class="w-32 h-20 object-cover rounded mb-2 shadow">
            @endif

            <input type="file" 
                   name="thumbnail"
                   class="w-full border rounded p-2">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Artikel
        </button>

    </form>

</div>

@endsection
