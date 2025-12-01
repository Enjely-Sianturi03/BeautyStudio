@extends('layouts.app')

@section('title', 'Beauty Tips & Care')

@section('content')

@php
    $currentCategory = request('category', 'all');
@endphp

<section class="relative h-96 bg-gradient-to-r from-pink-700 via-pink-700 to-pink-400 flex items-center justify-center">
    <div class="absolute inset-0 bg-black opacity-30"></div>
    <div class="text-center text-white px-4 z-10">
        <h1 class="text-5xl font-extrabold tracking-wider uppercase">BEAUTY TIPS & CARE</h1>
        <p class="mt-4 text-xl font-light">Kumpulan artikel dan video tentang kecantikan dan perawatan diri</p>
    </div>
</section>

{{-- CATEGORY FILTER --}}
<section class="bg-white border-b sticky top-[64px] z-50 shadow-md"> 
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-2 md:gap-4 py-4 md:py-6">
            @php
                $categories = [
                    'all' => 'Semua',
                    'skincare' => 'Skincare',
                    'haircare' => 'Perawatan Rambut',
                    'makeup' => 'Makeup',
                    'treatment' => 'Body Treatment'
                ];
            @endphp

            @foreach($categories as $key => $label)
                @php
                    $isActive = ($currentCategory == $key);
                    $routeUrl = ($key == 'all') 
                        ? route('tips.index') 
                        : route('tips.index', ['category' => $key]);
                @endphp

                <a href="{{ $routeUrl }}" 
                    class="px-5 py-2 text-sm md:text-base font-semibold rounded-full transition duration-300 
                    {{ $isActive ? 'bg-pink-600 text-white shadow-lg shadow-pink-500/50' : 'text-gray-700 border border-gray-300 hover:bg-pink-50 hover:border-pink-500' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- TIPS LIST --}}
<section class="py-16 md:py-20 bg-gray-50">
    <div class="container mx-auto px-4">

        @if($tips->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                @foreach($tips as $tip)
                    <!-- Card sebagai link -->
                    <a href="{{ $tip->link ?? '#' }}" 
                       target="_blank"
                       class="block bg-white rounded-xl shadow-xl hover:shadow-2xl transition duration-500 
                              overflow-hidden transform hover:-translate-y-1 group border border-gray-100">

                        {{-- Thumbnail / Video --}}
                        @if($tip->type === 'article')
                            <img src="{{ asset('storage/' . $tip->thumbnail) }}" 
                                 class="w-full h-56 object-cover transition duration-700 group-hover:scale-105"
                                 alt="{{ $tip->title }}">

                            <span class="absolute top-3 right-3 bg-pink-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">
                                Artikel
                            </span>

                        @else
                            <iframe class="w-full h-56" 
                                src="{{ $tip->video_url }}" 
                                frameborder="0" allowfullscreen></iframe>

                            <span class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">
                                Video
                            </span>
                        @endif

                        {{-- Konten --}}
                        <div class="p-6">
                            <span class="text-xs font-semibold uppercase text-pink-500 tracking-wider mb-2 block">
                                {{ ucfirst($tip->category) }}
                            </span>

                            <h3 class="text-xl font-bold text-gray-800 mb-3 leading-snug">
                                {{ Str::limit($tip->title, 50) }}
                            </h3>

                            <p class="text-gray-500 text-sm mb-4 line-clamp-3">
                                {{ Str::limit($tip->content, 100) }}
                            </p>

                            <span class="inline-flex items-center text-pink-600 font-bold group-hover:underline">
                                Baca Selengkapnya
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>

                    </a>
                @endforeach

            </div>

            <div class="mt-12 flex justify-center">
                {{ $tips->links() }}
            </div>

        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-lg border border-gray-100">
                <p class="text-2xl font-semibold text-gray-700">
                    Belum ada konten untuk kategori 
                    <strong>{{ $currentCategory == 'all' ? 'ini' : ucfirst($currentCategory) }}</strong>.
                </p>

                <a href="{{ route('tips.index') }}" 
                   class="inline-block mt-4 bg-pink-600 text-white font-medium px-8 py-3 rounded-full hover:bg-pink-700 transition shadow-lg">
                    Lihat Semua Tips
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
