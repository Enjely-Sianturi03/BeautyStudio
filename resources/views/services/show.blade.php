@extends('layouts.app')

@section('title', $service->name)

@section('content')
<!-- Service Detail Section -->
<section class="py-20 bg-gradient-to-b from-pink-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-pink-600 transition">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-pink-600 transition">Services</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-pink-600 font-medium">{{ $service->name }}</span>
            </nav>

            <!-- Single Column Layout -->
            <div class="bg-white p-8 md:p-12 shadow-2xl rounded-2xl border border-pink-100">
                <!-- Header Section -->
                <div class="text-center mb-12 pb-8 border-b border-pink-200">
                    <!-- Icon -->
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full mb-6 shadow-lg">
                        <i class="fas fa-cut text-4xl text-white"></i>
                    </div>
                    
                    <!-- Category Badge -->
                    <div class="inline-block bg-pink-100 text-pink-600 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                        {{ ucfirst($service->category) }}
                    </div>
                    
                    <!-- Service Name -->
                    <h1 class="text-4xl md:text-5xl font-light mb-6 text-gray-800">{{ $service->name }}</h1>
                    
                    <!-- Price and Duration -->
                    <div class="flex items-center justify-center space-x-8">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-pink-600">Rp{{ number_format($service->price, 2) }}</div>
                            <div class="text-sm text-gray-500 mt-2">Starting price</div>
                        </div>
                        <div class="h-16 w-px bg-pink-300"></div>
                        <div class="text-center">
                            <div class="text-3xl font-medium text-gray-700">
                                <i class="far fa-clock mr-2 text-pink-500"></i>{{ $service->formatted_duration }}
                            </div>
                            <div class="text-sm text-gray-500 mt-2">Duration</div>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid md:grid-cols-2 gap-10 mb-10">
                    <!-- Description -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-align-left text-pink-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">Description</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg pl-16">{{ $service->description }}</p>
                    </div>

                    <!-- What's Included -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-check-double text-pink-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">What's Included</h3>
                        </div>
                        <ul class="space-y-3 pl-16">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-500 mr-3 mt-1 text-xl"></i>
                                <span class="text-gray-700">Professional consultation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-500 mr-3 mt-1 text-xl"></i>
                                <span class="text-gray-700">Premium products</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-500 mr-3 mt-1 text-xl"></i>
                                <span class="text-gray-700">Complimentary wellness ritual</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-500 mr-3 mt-1 text-xl"></i>
                                <span class="text-gray-700">Styling tips and aftercare advice</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="grid md:grid-cols-2 gap-4 max-w-3xl mx-auto pt-8 border-t border-pink-200">
                    <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" 
                       class="block text-center bg-gradient-to-r from-pink-500 to-pink-600 text-white px-8 py-4 hover:from-pink-600 hover:to-pink-700 transition-all duration-300 font-semibold text-lg rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="far fa-calendar-check mr-2"></i>BOOK THIS SERVICE
                    </a>
                    <a href="{{ route('services.index') }}" 
                       class="block text-center border-2 border-pink-500 text-pink-600 px-8 py-4 hover:bg-pink-500 hover:text-white transition-all duration-300 font-semibold text-lg rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>VIEW ALL SERVICES
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Services -->
@if($relatedServices->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-light text-gray-800 mb-4">You Might Also Like</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-pink-400 to-pink-600 mx-auto"></div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($relatedServices as $related)
            <div class="group bg-white border-2 border-pink-200 hover:border-pink-400 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 rounded-xl p-6">
                <!-- Icon and Title -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300 shadow-md">
                        <i class="fas fa-cut text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors">
                        {{ $related->name }}
                    </h3>
                </div>
                
                <!-- Description -->
                <p class="text-gray-600 mb-6 text-sm leading-relaxed text-center min-h-[60px]">
                    {{ Str::limit($related->description, 100) }}
                </p>
                
                <!-- Price and Duration -->
                <div class="flex justify-between items-center mb-6 pb-4 border-t border-b border-pink-100 pt-4">
                    <span class="text-2xl font-bold text-pink-600">${{ number_format($related->price, 0) }}</span>
                    <span class="text-gray-500 text-sm flex items-center">
                        <i class="far fa-clock mr-1 text-pink-400"></i>
                        {{ $related->formatted_duration }}
                    </span>
                </div>
                
                <!-- Button -->
                <a href="{{ route('services.show', $related) }}" 
                   class="block w-full text-center bg-pink-500 text-white px-4 py-3 hover:bg-pink-600 transition-all duration-300 font-semibold rounded-lg shadow-md hover:shadow-lg">
                    VIEW DETAILS
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection