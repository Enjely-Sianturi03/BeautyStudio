@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<!-- Page Header -->
<section class="relative h-96 bg-gradient-to-r from-purple-900 via-pink-900 to-purple-900 flex items-center justify-center">
    <div class="text-center text-white px-4">
        <h1 class="text-5xl md:text-6xl font-light mb-4">OUR GALLERY</h1>
        <p class="text-xl md:text-2xl font-light">Showcasing our finest work and transformations</p>
    </div>
</section>

<!-- Filter Tabs -->
<section class="bg-white border-b sticky top-20 z-40 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-4 py-6">
            @foreach($categories as $key => $label)
            <a href="{{ route('gallery.index', ['category' => $key]) }}" 
               class="px-6 py-2 font-medium transition {{ request('category', 'all') == $key ? 'bg-black text-white' : 'border-2 border-gray-300 text-gray-700 hover:border-black' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($galleries->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
            <div class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="aspect-w-4 aspect-h-5 relative">
                    <img src="{{ asset('storage/' . $gallery->image) }}" 
                         alt="{{ $gallery->title }}" 
                         class="w-full h-96 object-cover transform group-hover:scale-110 transition-transform duration-700"
                         loading="lazy">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-xl font-medium mb-2">{{ $gallery->title }}</h3>
                            <p class="text-sm text-gray-300 capitalize">{{ $gallery->category }}</p>
                            
                            @if($gallery->is_featured)
                            <span class="inline-block mt-2 px-3 py-1 bg-yellow-500 text-black text-xs font-semibold rounded-full">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                            @endif
                        </div>
                        
                        <!-- View Icon -->
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button onclick="openModal('{{ asset('storage/' . $gallery->image) }}', '{{ $gallery->title }}')" 
                                    class="bg-white text-black p-3 rounded-full hover:bg-gray-200 transition">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $galleries->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500">No gallery images found in this category.</p>
            <a href="{{ route('gallery.index') }}" class="inline-block mt-6 border-2 border-black px-8 py-3 hover:bg-black hover:text-white transition font-medium">
                VIEW ALL
            </a>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-light mb-6">Ready to Get Your Own Transformation?</h2>
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
            Let our expert stylists create a stunning new look for you
        </p>
        <a href="{{ route('appointments.create') }}" 
           class="inline-block bg-black text-white px-12 py-4 text-lg font-medium hover:bg-gray-800 transition transform hover:scale-105">
            BOOK YOUR APPOINTMENT
        </a>
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
    <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 transition">
        <i class="fas fa-times"></i>
    </button>
    
    <div class="max-w-6xl w-full">
        <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[90vh] object-contain rounded-lg">
        <p id="modalTitle" class="text-white text-center text-xl mt-4"></p>
    </div>
    
    <button onclick="closeModal()" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 bg-white text-black px-6 py-2 rounded-full hover:bg-gray-200 transition">
        Close
    </button>
</div>

@push('scripts')
<script>
    function openModal(imageSrc, title) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        
        modalImage.src = imageSrc;
        modalTitle.textContent = title;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    
    // Close modal on background click
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endpush
@endsection