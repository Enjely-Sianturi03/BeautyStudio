@extends('layouts.app')

@section('title', 'Home - Modern Artistic Hair')

@section('content')
<!-- Hero Section -->
<section 
    x-data="{
        active: 0,
        slides: [
            {
                image: '{{ asset('image/gambar1.jpeg') }}',
                title: 'MODERN',
                subtitle: 'ARTISTIC HAIR',
                description: 'Transform your look with our expert haircut and styling services. Experience a personalized touch that brings out your unique style.'
            },
            {
                image: '{{ asset('image/nails.jpg') }}',
                title: 'ELEGANT',
                subtitle: 'NAILS & CARE',
                description: 'Pamper your hands and feet with professional manicure and pedicure services. Enjoy flawless nails with luxurious care.'
            },
            {
                image: '{{ asset('image/lashes1.webp') }}',
                title: 'LUXURIOUS',
                subtitle: 'LASHES & BEAUTY',
                description: 'Enhance your eyes with our signature eyelash extensions and treatments. Create a captivating look that lasts.'
            }
        ]
    }"
    x-init="setInterval(() => { active = (active + 1) % slides.length }, 5000)"
    class="relative h-screen overflow-hidden">

    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="active === index"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-105"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute inset-0">
            <img :src="slide.image" alt="Beauty Studio" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
    </template>

    <div class="relative z-10 flex items-center justify-center h-full text-center text-white px-4">
        <div class="max-w-4xl">
            <h1 x-text="slides[active].title" class="text-5xl md:text-7xl font-extrabold mb-6 tracking-wider animate-fade-in drop-shadow-lg text-white"></h1>
            <h2 x-text="slides[active].subtitle" class="text-4xl md:text-6xl font-bold mb-8 animate-fade-in-delay drop-shadow-md text-white"></h2>
            <p x-text="slides[active].description" class="text-xl md:text-2xl mb-10 font-serif leading-relaxed animate-fade-in-delay-2 drop-shadow text-gray-200"></p>
            <a href="{{ route('appointments.create') }}" class="inline-block bg-pink-500 text-white px-10 py-4 text-lg font-medium hover:bg-pink-600 transition transform hover:scale-105 shadow-lg rounded-full">
                BOOK APPOINTMENT
            </a>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
        <i class="fas fa-chevron-down text-white text-3xl drop-shadow-lg"></i>
    </div>
</section>


<!-- Wellness Rituals Section -->
<section class="py-20 bg-gradient-to-b from-pink-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto mb-16">
            <h2 class="text-4xl md:text-5xl font-light mb-6 text-pink-700">YOUR MINIATURE GETAWAY</h2>
            <p class="text-xl md:text-2xl text-pink-600 leading-relaxed">
                Indulge in our exclusive beauty services for a refreshing and glamorous experience.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <div class="bg-pink-50 p-10 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 rounded-lg border-t-4 border-pink-400">
                <div class="text-center">
                    <div class="inline-block p-6 bg-pink-100 rounded-full mb-6">
                        <i class="fas fa-spa text-5xl text-pink-600"></i>
                    </div>
                    <h3 class="text-2xl font-light mb-4 text-pink-700">HAIR TREATMENTS<br>HAIR TREATMENTS</h3>
                    <p class="text-pink-600 leading-relaxed">
                        Nourish, repair, and revitalize your hair with our professional treatments.
                    </p>
                </div>
            </div>

            <div class="bg-pink-50 p-10 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 rounded-lg border-t-4 border-pink-400">
                <div class="text-center">
                    <div class="inline-block p-6 bg-pink-100 rounded-full mb-6">
                        <i class="fas fa-hand-sparkles text-5xl text-pink-600"></i>
                    </div>
                    <h3 class="text-2xl font-light mb-4 text-pink-700">NAILS<br>NAILS</h3>
                    <p class="text-pink-600 leading-relaxed">
                        Pamper your hands and feet with expert manicure and pedicure services.
                    </p>
                </div>
            </div>

            <div class="bg-pink-50 p-10 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 rounded-lg border-t-4 border-pink-400">
                <div class="text-center">
                    <div class="inline-block p-6 bg-pink-100 rounded-full mb-6">
                        <i class="fas fa-spa text-5xl text-pink-600"></i>
                    </div>
                    <h3 class="text-2xl font-light mb-4 text-pink-700">LASHES<br>LASHES</h3>
                    <p class="text-pink-600 leading-relaxed">
                        Enhance your eyes with professional eyelash extensions and treatments.
                    </p>
                </div>
            </div>

            <div class="bg-pink-50 p-10 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 rounded-lg border-t-4 border-pink-400">
                <div class="text-center">
                    <div class="inline-block p-6 bg-pink-100 rounded-full mb-6">
                        <i class="fas fa-spa text-5xl text-pink-600"></i>
                    </div>
                    <h3 class="text-2xl font-light mb-4 text-pink-700">SALON SERVICES<br>SALON SERVICES</h3>
                    <p class="text-pink-600 leading-relaxed">
                        Enjoy premium haircuts, styling, and color services tailored to you.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- TIPS PREVIEW SECTION (GANTI BAGIAN GALERI) -->
@if(isset($tips) && $tips->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-light text-center mb-16 text-pink-700">BEAUTY TIPS</h2>

        <div class="grid md:grid-cols-3 gap-6 mb-12">
            @foreach($tips as $tip)
            <div class="relative overflow-hidden group rounded-lg shadow-lg border border-pink-200 bg-white">
                <img src="{{ asset('storage/' . $tip->thumbnail) }}" 
                     alt="{{ $tip->title }}" 
                     class="w-full h-72 object-cover transform group-hover:scale-110 transition duration-700">

                <div class="absolute inset-0 bg-gradient-to-t from-pink-700/80 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-xl font-medium">{{ $tip->title }}</h3>
                        <p class="text-sm text-pink-200">{{ Str::limit($tip->category, 20) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('tips.index') }}" class="inline-block border-2 border-pink-600 text-pink-600 px-10 py-3 text-lg font-medium hover:bg-pink-600 hover:text-white transition transform hover:scale-105 rounded-full">
                VIEW ALL TIPS
            </a>
        </div>
    </div>
</section>
@endif



<!-- Services Preview -->
@if(isset($services) && $services->count() > 0)
<section class="py-20 bg-pink-700 text-pink-200">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-light text-center mb-16 text-pink-100">LAYANAN KAMI</h2>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($services->take(3) as $service)
            <div class="bg-pink-800 p-8 border border-pink-400 hover:border-white transition transform hover:-translate-y-2 rounded-lg">
                <div class="text-center">
                    <h3 class="text-2xl font-light mb-4">{{ $service->name }}</h3>
                    <p class="text-pink-200 mb-6 leading-relaxed">{{ Str::limit($service->description, 120) }}</p>
                    <div class="mb-6">
                        <span class="text-3xl font-light">${{ number_format($service->price, 0) }}</span>
                        <span class="text-pink-300 text-sm ml-2">{{ $service->formatted_duration }}</span>
                    </div>
                    <a href="{{ route('services.show', $service) }}" class="inline-block text-sm border border-pink-200 px-6 py-2 hover:bg-pink-200 hover:text-pink-900 transition rounded-full">
                        LEARN MORE
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('services.index') }}" class="inline-block border-2 border-pink-200 px-10 py-3 text-lg font-medium hover:bg-pink-200 hover:text-pink-900 transition transform hover:scale-105 rounded-full">
                VIEW ALL SERVICES
            </a>
        </div>
    </div>
</section>
@endif


<!-- CTA Section -->
<!-- <section class="py-20 bg-pink-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-light mb-6 text-pink-700">Ready for a Transformation?</h2>
        <p class="text-xl text-pink-600 mb-10 max-w-2xl mx-auto">
            Book your appointment today and experience the Artika difference
        </p>
        <a href="{{ route('appointments.create') }}" 
           class="inline-block bg-pink-600 text-white px-12 py-4 text-lg font-medium hover:bg-pink-700 transition transform hover:scale-105 shadow-xl rounded-full">
            SCHEDULE YOUR VISIT
        </a>
    </div>
</section> -->
<!-- CUSTOMER REVIEWS SECTION -->
@if(isset($reviews) && $reviews->count() > 0)
<!-- CUSTOMER REVIEWS SECTION -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">

        <h2 class="text-4xl md:text-5xl font-light text-center mb-16 text-pink-700">
            WHAT OUR CUSTOMERS SAY
        </h2>

        @if($reviews->count() > 0)
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                <div class="bg-pink-50 shadow-lg hover:shadow-xl transition rounded-xl p-8 border border-pink-200">
                    
                    <!-- Rating -->
                    <div class="flex mb-4 text-yellow-500 text-xl">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>

                    <!-- Message -->
                    <p class="text-pink-700 leading-relaxed mb-6">
                        "{{ $review->message }}"
                    </p>

                    <!-- Name -->
                    <h3 class="text-lg font-semibold text-pink-900">
                        — {{ $review->name }}
                    </h3>

                </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-pink-600 text-xl">
                Belum ada ulasan dari pelanggan.
            </p>
        @endif

        <div class="text-center mt-12">
            <a href="{{ route('contact') }}"
               class="inline-block border-2 border-pink-600 text-pink-600 px-10 py-3 text-lg font-medium 
                      hover:bg-pink-600 hover:text-white transition rounded-full">
                GIVE YOUR REVIEW
            </a>
        </div>

    </div>
</section>
@endif



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
