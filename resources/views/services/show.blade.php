@extends('layouts.app')

@section('title', $service->name)

@section('content')
<!-- Service Detail Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-gray-700">Services</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900">{{ $service->name }}</span>
            </nav>

            <div class="grid md:grid-cols-2 gap-12 bg-white p-8 md:p-12 shadow-xl rounded-lg">
                <!-- Service Image -->
                <div class="relative">
                    @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         alt="{{ $service->name }}" 
                         class="w-full h-96 object-cover rounded-lg shadow-lg">
                    @else
                    <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded-lg">
                        <i class="fas fa-cut text-8xl text-gray-400"></i>
                    </div>
                    @endif
                    
                    <div class="absolute top-4 left-4 bg-black text-white px-4 py-2 rounded-full">
                        <span class="text-sm font-medium">{{ ucfirst($service->category) }}</span>
                    </div>
                </div>

                <!-- Service Info -->
                <div>
                    <h1 class="text-4xl md:text-5xl font-light mb-6">{{ $service->name }}</h1>
                    
                    <div class="flex items-center space-x-6 mb-8 pb-8 border-b">
                        <div>
                            <div class="text-4xl font-light text-gray-900">${{ number_format($service->price, 2) }}</div>
                            <div class="text-sm text-gray-500 mt-1">Starting price</div>
                        </div>
                        <div class="h-12 w-px bg-gray-300"></div>
                        <div>
                            <div class="text-2xl font-light text-gray-900">
                                <i class="far fa-clock mr-2"></i>{{ $service->formatted_duration }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Duration</div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-2xl font-medium mb-4">Description</h3>
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $service->description }}</p>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-2xl font-medium mb-4">What's Included</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Professional consultation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Premium products</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Complimentary wellness ritual</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700">Styling tips and aftercare advice</span>
                            </li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" 
                           class="block w-full text-center bg-black text-white px-8 py-4 hover:bg-gray-800 transition font-medium text-lg">
                            BOOK THIS SERVICE
                        </a>
                        <a href="{{ route('services.index') }}" 
                           class="block w-full text-center border-2 border-black px-8 py-4 hover:bg-black hover:text-white transition font-medium text-lg">
                            VIEW ALL SERVICES
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Services -->
@if($relatedServices->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-light text-center mb-12">You Might Also Like</h2>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($relatedServices as $related)
            <div class="bg-white border border-gray-200 hover:border-gray-400 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 rounded-lg overflow-hidden">
                @if($related->image)
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $related->image) }}" 
                         alt="{{ $related->name }}" 
                         class="w-full h-full object-cover hover:scale-110 transition duration-500">
                </div>
                @else
                <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <i class="fas fa-cut text-6xl text-gray-400"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-medium mb-2">{{ $related->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($related->description, 100) }}</p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-light">${{ number_format($related->price, 0) }}</span>
                        <span class="text-gray-500 text-sm">{{ $related->formatted_duration }}</span>
                    </div>
                    
                    <a href="{{ route('services.show', $related) }}" 
                       class="block w-full text-center border-2 border-black px-4 py-2 hover:bg-black hover:text-white transition font-medium">
                        VIEW DETAILS
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection