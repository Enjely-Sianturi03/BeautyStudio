@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<!-- Page Header -->
<section class="relative h-[500px] bg-gradient-to-br from-pink-600 via-pink-700 to-pink-900 flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative z-10 text-center text-white px-4 max-w-4xl mx-auto">
        <h1 class="text-5xl md:text-7xl font-extralight mb-6 tracking-wide">LAYANAN KAMI</h1>
        <div class="w-24 h-1 bg-white mx-auto mb-6"></div>
        <p class="text-lg md:text-xl font-light opacity-90 leading-relaxed">
            Premium hair care tailored to your unique style
        </p>
    </div>
</section>

<!-- Services Section -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Section Title -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-light text-gray-800 mb-4">Explore Our Services</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Discover the perfect treatment for your hair with our range of professional services
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach($services as $service)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100">
                <!-- Card Header with Gradient -->
                <div class="h-3 bg-gradient-to-r from-pink-500 to-pink-700"></div>
                
                <div class="p-8">
                    <!-- Service Title -->
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800 group-hover:text-pink-600 transition-colors">
                        {{ $service->nama }}
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-600 mb-6 leading-relaxed min-h-[80px]">
                        {{ Str::limit($service->deskripsi, 120) }}
                    </p>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 mb-6"></div>

                    <!-- Price and Duration -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-3xl font-bold text-pink-600">
                                Rp{{ number_format($service->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex items-center text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            <span class="text-sm font-medium">{{ $service->durasi_menit }} min</span>
                        </div>
                    </div>

                    <!-- Button -->
                    <a href="{{ route('services.show', $service->id) }}" 
                       class="block w-full text-center bg-gradient-to-r from-pink-500 to-pink-600 text-white px-6 py-3 rounded-lg hover:from-pink-600 hover:to-pink-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-1">
                        Learn More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-pink-900 text-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-pink-500 rounded-full filter blur-3xl opacity-10"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-600 rounded-full filter blur-3xl opacity-10"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Icon -->
            <div class="w-20 h-20 bg-pink-500 bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-8">
                <i class="fas fa-question-circle text-4xl text-pink-400"></i>
            </div>

            <h2 class="text-4xl md:text-5xl font-light mb-6 leading-tight">
                Not Sure Which Service to Choose?
            </h2>
            <p class="text-xl mb-12 max-w-2xl mx-auto text-gray-300 leading-relaxed">
                Our expert stylists are here to help you find the perfect service for your needs. Get personalized recommendations today.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                <a href="https://wa.me/6283876821276?text=Halo%20kak,%20saya%20ingin%20bertanya%20tentang%20layanan%20salon."
                class="group inline-flex items-center border-2 border-white px-10 py-4 rounded-lg hover:bg-white hover:text-gray-900 transition-all duration-300 font-semibold text-lg transform hover:-translate-y-1">
                    <i class="fas fa-phone mr-3 group-hover:rotate-12 transition-transform"></i>
                    CALL US NOW
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-12 pt-8 border-t border-gray-700">
                <p class="text-gray-400">
                    Available Monday - Saturday, 9:00 AM - 8:00 PM
                </p>
            </div>
        </div>
    </div>
</section>
@endsection