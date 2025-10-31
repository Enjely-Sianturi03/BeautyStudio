@extends('layouts.app')

@section('title', 'Home - Modern Artistic Hair')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen">
    <div class="absolute inset-0">
        <img src="{{ asset('image/gambar1.jpeg') }}" alt="Artika Salon" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/70"></div>
    </div>

    <div class="relative z-10 flex items-center justify-center h-full text-center text-white px-4">
        <div class="max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-light mb-6 tracking-wider animate-fade-in">MODERN</h1>
            <h2 class="text-4xl md:text-6xl font-serif mb-8 animate-fade-in-delay">ARTISTIC HAIR</h2>
            <p class="text-xl md:text-2xl mb-10 font-light leading-relaxed animate-fade-in-delay-2">
                A destination salon known for its customer service and sensory experience.<br>
                Based on the belief that everything that touches us affects us in larger ways.
            </p>
            <a href="{{ route('appointments.create') }}" class="inline-block bg-white text-black px-10 py-4 text-lg font-medium hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                BOOK APPOINTMENT
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white text-3xl"></i>
    </div>
</section>

<!-- Wellness Rituals Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-light mb-6">YOUR MINIATURE GETAWAY</h2>
            <p class="text-xl md:text-2xl text-gray-700 leading-relaxed">
                Receive one of our complimentary wellness rituals with any haircut or color service.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <div class="bg-white p-10 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 rounded-lg">
                <div class="text-center">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-spa text-5xl text-gray-800"></i>
                    </div>
                    <h3 class="text-2xl font-light mb-4">STRESS RELIEVING<br>SCALP MASSAGE</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Relax and rejuvenate with our signature scalp treatment designed to melt away tension and restore balance.
                    </p>
                </div>
            </div>

            <div class="bg-white p-10 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 rounded-lg">
                <div class="text-center">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-hand-sparkles text-5xl text-gray-800"></i>
                    </div>
                    <h3 class="text-2xl font-light mb-4">HAND & ARM<br>MASSAGE</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Indulge in a soothing hand and arm massage experience that enhances your salon visit.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Preview Section -->
@if($featuredGalleries->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-light text-center mb-16">OUR WORK</h2>

        <div class="grid md:grid-cols-3 gap-6 mb-12">
            @foreach($featuredGalleries as $gallery)
            <div class="relative overflow-hidden group rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $gallery->image) }}" 
                     alt="{{ $gallery->title }}" 
                     class="w-full h-96 object-cover transform group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-xl font-medium">{{ $gallery->title }}</h3>
                        <p class="text-sm text-gray-300">{{ ucfirst($gallery->category) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('gallery.index') }}" class="inline-block border-2 border-black px-10 py-3 text-lg font-medium hover:bg-black hover:text-white transition transform hover:scale-105">
                VIEW FULL GALLERY
            </a>
        </div>
    </div>
</section>
@endif

<!-- Services Preview -->
@if($services->count() > 0)
<section class="py-20 bg-gray-900 text-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-light text-center mb-16">OUR SERVICES</h2>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($services->take(3) as $service)
            <div class="bg-gray-800 p-8 border border-gray-700 hover:border-white transition transform hover:-translate-y-2 rounded-lg">
                <div class="text-center">
                    <h3 class="text-2xl font-light mb-4">{{ $service->name }}</h3>
                    <p class="text-gray-400 mb-6 leading-relaxed">{{ Str::limit($service->description, 120) }}</p>
                    <div class="mb-6">
                        <span class="text-3xl font-light">${{ number_format($service->price, 0) }}</span>
                        <span class="text-gray-400 text-sm ml-2">{{ $service->formatted_duration }}</span>
                    </div>
                    <a href="{{ route('services.show', $service) }}" class="inline-block text-sm border border-white px-6 py-2 hover:bg-white hover:text-black transition">
                        LEARN MORE
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('services.index') }}" class="inline-block border-2 border-white px-10 py-3 text-lg font-medium hover:bg-white hover:text-black transition transform hover:scale-105">
                VIEW ALL SERVICES
            </a>
        </div>
    </div>
</section>
@endif

<!-- Stylists Section -->
@if($stylists->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-light text-center mb-6">MEET OUR STYLISTS</h2>
        <p class="text-center text-xl text-gray-600 mb-16 max-w-2xl mx-auto">
            Our talented team of professionals is dedicated to bringing your vision to life
        </p>

        <div class="grid md:grid-cols-4 gap-8">
            @foreach($stylists as $stylist)
            <div class="text-center group">
                <div class="relative overflow-hidden rounded-lg mb-4 shadow-lg">
                    @if($stylist->photo)
                    <img src="{{ asset('storage/' . $stylist->photo) }}" 
                         alt="{{ $stylist->name }}" 
                         class="w-full h-80 object-cover transform group-hover:scale-110 transition duration-500">
                    @else
                    <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-6xl text-gray-400"></i>
                    </div>
                    @endif
                </div>
                <h3 class="text-xl font-medium mb-2">{{ $stylist->name }}</h3>
                <p class="text-gray-600 text-sm">{{ $stylist->experience_years }} years experience</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Social Media Section -->
<section class="py-20 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight">#ArtikaHairSpa</h2>
        <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto text-gray-300">
            Follow our journey on Instagram for the latest style inspiration, transformations, and exclusive seasonal offers.
        </p>
        <a href="https://instagram.com/artikahairspa" target="_blank" 
            class="inline-block bg-pink-500 text-white px-12 py-4 rounded-full hover:bg-pink-600 transition duration-300 transform hover:scale-105 font-bold text-lg shadow-xl uppercase tracking-widest">
            <i class="fab fa-instagram mr-3 text-2xl"></i> FOLLOW US NOW
        </a>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-light mb-6">Ready for a Transformation?</h2>
        <p class="text-xl text-gray-700 mb-10 max-w-2xl mx-auto">
            Book your appointment today and experience the Artika difference
        </p>
        <a href="{{ route('appointments.create') }}" 
           class="inline-block bg-black text-white px-12 py-4 text-lg font-medium hover:bg-gray-800 transition transform hover:scale-105 shadow-xl">
            SCHEDULE YOUR VISIT
        </a>
    </div>
</section>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 1s ease-out;
    }
    .animate-fade-in-delay {
        animation: fadeIn 1s ease-out 0.3s both;
    }
    .animate-fade-in-delay-2 {
        animation: fadeIn 1s ease-out 0.6s both;
    }
</style>
@endsection
