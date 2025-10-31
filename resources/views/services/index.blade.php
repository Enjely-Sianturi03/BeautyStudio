@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<!-- Page Header -->
<section class="relative h-96 bg-gradient-to-r from-gray-900 to-gray-700 flex items-center justify-center">
    <div class="text-center text-white px-4">
        <h1 class="text-5xl md:text-6xl font-light mb-4">OUR SERVICES</h1>
        <p class="text-xl md:text-2xl font-light">Premium hair care tailored to your unique style</p>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        @foreach($categories as $categoryKey => $categoryName)
            @if(isset($services[$categoryKey]) && $services[$categoryKey]->count() > 0)
            <div class="mb-20">
                <h2 class="text-4xl font-light mb-10 pb-4 border-b-2 border-gray-200">{{ $categoryName }}</h2>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services[$categoryKey] as $service)
                    <div class="bg-white border border-gray-200 hover:border-gray-400 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 rounded-lg overflow-hidden">
                        @if($service->image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i class="fas fa-cut text-6xl text-gray-400"></i>
                        </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-2xl font-medium mb-3">{{ $service->name }}</h3>
                            <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit($service->description, 150) }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <span class="text-3xl font-light text-gray-900">${{ number_format($service->price, 0) }}</span>
                                </div>
                                <div class="text-gray-500">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $service->formatted_duration }}
                                </div>
                            </div>
                            
                            <div class="flex space-x-3">
                                <a href="{{ route('services.show', $service) }}" 
                                   class="flex-1 text-center border-2 border-black px-4 py-2 hover:bg-black hover:text-white transition font-medium">
                                    VIEW DETAILS
                                </a>
                                <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" 
                                   class="flex-1 text-center bg-black text-white px-4 py-2 hover:bg-gray-800 transition font-medium">
                                    BOOK NOW
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach

        @if($services->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-info-circle text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500">No services available at the moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-light mb-6">Not Sure Which Service to Choose?</h2>
        <p class="text-xl mb-10 max-w-2xl mx-auto">
            Our expert stylists are here to help you find the perfect service for your needs
        </p>
        <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-6">
            <a href="{{ route('appointments.create') }}" 
               class="inline-block bg-white text-black px-10 py-4 hover:bg-gray-200 transition font-medium text-lg">
                BOOK CONSULTATION
            </a>
            <a href="tel:5621234567" 
               class="inline-block border-2 border-white px-10 py-4 hover:bg-white hover:text-black transition font-medium text-lg">
                <i class="fas fa-phone mr-2"></i> CALL US
            </a>
        </div>
    </div>
</section>
@endsection