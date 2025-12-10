@extends('layouts.app')

@section('title', 'Beranda - Modern Artistic Hair')

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
                description: 'Ubah penampilan Anda dengan layanan potong dan styling rambut profesional kami. Rasakan sentuhan personal yang memunculkan gaya unik Anda.'
            },
            {
                image: '{{ asset('image/nails.jpg') }}',
                title: 'ELEGANT',
                subtitle: 'PERAWATAN KUKU',
                description: 'Manjakan tangan dan kaki Anda dengan layanan manikur dan pedikur profesional. Nikmati kuku sempurna dengan perawatan mewah.'
            },
            {
                image: '{{ asset('image/lashes1.webp') }}',
                title: 'LUXURIOUS',
                subtitle: 'BULU MATA & KECANTIKAN',
                description: 'Percantik mata Anda dengan ekstensi bulu mata dan perawatan signature kami. Ciptakan tampilan menawan yang tahan lama.'
            }
        ]
    }"
    x-init="setInterval(() => { active = (active + 1) % slides.length }, 5000)"
    class="relative h-screen overflow-hidden">

    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="active === index"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 scale-105"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-700"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute inset-0">
            <img :src="slide.image" alt="Beauty Studio" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/50 to-black/70"></div>
        </div>
    </template>

    <div class="relative z-10 flex items-center justify-center h-full text-center text-white px-4">
        <div class="max-w-4xl">
            <h1 x-text="slides[active].title" class="text-6xl md:text-8xl font-extrabold mb-4 tracking-widest animate-fade-in drop-shadow-2xl text-white"></h1>
            <h2 x-text="slides[active].subtitle" class="text-3xl md:text-5xl font-light mb-8 animate-fade-in-delay drop-shadow-lg text-pink-200 tracking-wide"></h2>
            <p x-text="slides[active].description" class="text-lg md:text-xl mb-12 font-light leading-relaxed animate-fade-in-delay-2 drop-shadow-lg text-gray-100 max-w-3xl mx-auto"></p>
            <a href="{{ route('appointments.create') }}" class="inline-block bg-gradient-to-r from-pink-500 to-pink-600 text-white px-12 py-4 text-lg font-semibold hover:from-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-2xl rounded-full uppercase tracking-wider">
                Buat Janji
            </a>
        </div>
    </div>

    <!-- Slide Indicators -->
    <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
        <template x-for="(slide, index) in slides" :key="index">
            <button 
                @click="active = index"
                :class="active === index ? 'bg-white w-10' : 'bg-white/50 w-3'"
                class="h-3 rounded-full transition-all duration-300">
            </button>
        </template>
    </div>

    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
        <i class="fas fa-chevron-down text-white text-3xl drop-shadow-lg opacity-75"></i>
    </div>
</section>


<!-- Wellness Rituals Section -->
<section class="py-24 bg-gradient-to-b from-pink-50 via-white to-pink-50">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto mb-20">
            <h2 class="text-5xl md:text-6xl font-light mb-6 text-pink-800 tracking-wide">PELARIAN MINI ANDA</h2>
            <div class="w-24 h-1 bg-pink-500 mx-auto mb-6"></div>
            <p class="text-xl md:text-2xl text-pink-600 leading-relaxed font-light">
                Nikmati layanan kecantikan eksklusif kami untuk pengalaman yang menyegarkan dan glamor.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            <div class="group bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 rounded-2xl border border-pink-100 hover:border-pink-300">
                <div class="text-center">
                    <div class="inline-block p-6 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-cut text-4xl text-pink-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-pink-800 uppercase tracking-wide">Perawatan Rambut</h3>
                    <p class="text-pink-600 leading-relaxed text-sm">
                        Rawat, perbaiki, dan revitalisasi rambut Anda dengan perawatan profesional kami.
                    </p>
                </div>
            </div>

            <div class="group bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 rounded-2xl border border-pink-100 hover:border-pink-300">
                <div class="text-center">
                    <div class="inline-block p-6 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hand-sparkles text-4xl text-pink-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-pink-800 uppercase tracking-wide">Perawatan Kuku</h3>
                    <p class="text-pink-600 leading-relaxed text-sm">
                        Manjakan tangan dan kaki Anda dengan layanan manikur dan pedikur ahli.
                    </p>
                </div>
            </div>

            <div class="group bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 rounded-2xl border border-pink-100 hover:border-pink-300">
                <div class="text-center">
                    <div class="inline-block p-6 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-eye text-4xl text-pink-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-pink-800 uppercase tracking-wide">Bulu Mata</h3>
                    <p class="text-pink-600 leading-relaxed text-sm">
                        Percantik mata Anda dengan ekstensi bulu mata dan perawatan profesional.
                    </p>
                </div>
            </div>

            <div class="group bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 rounded-2xl border border-pink-100 hover:border-pink-300">
                <div class="text-center">
                    <div class="inline-block p-6 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-spa text-4xl text-pink-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-pink-800 uppercase tracking-wide">Layanan Salon</h3>
                    <p class="text-pink-600 leading-relaxed text-sm">
                        Nikmati potong rambut, styling, dan layanan pewarnaan premium yang disesuaikan untuk Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- TIPS PREVIEW SECTION  -->
@if(isset($tips) && $tips->count() > 0)
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-light mb-6 text-pink-800 tracking-wide">TIPS KECANTIKAN</h2>
            <div class="w-24 h-1 bg-pink-500 mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($tips as $tip)
            <div class="relative overflow-hidden group rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-pink-100">
                <img src="{{ asset('storage/' . $tip->thumbnail) }}" 
                     alt="{{ $tip->title }}" 
                     class="w-full h-80 object-cover transform group-hover:scale-110 transition-transform duration-700">

                <div class="absolute inset-0 bg-gradient-to-t from-pink-900/90 via-pink-900/50 to-transparent opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-semibold mb-2">{{ $tip->title }}</h3>
                        <p class="text-sm text-pink-200 uppercase tracking-wide">{{ Str::limit($tip->category, 20) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('tips.index') }}" class="inline-block border-2 border-pink-600 text-pink-600 px-12 py-4 text-lg font-semibold hover:bg-pink-600 hover:text-white transition-all duration-300 transform hover:scale-105 rounded-full uppercase tracking-wider shadow-lg hover:shadow-xl">
                Lihat Semua Tips
            </a>
        </div>
    </div>
</section>
@endif



<!-- Services Preview -->
@if(isset($services) && $services->count() > 0)
<section class="py-24 bg-gradient-to-br from-pink-700 via-pink-800 to-pink-900 text-pink-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-light mb-6 text-white tracking-wide">LAYANAN KAMI</h2>
            <div class="w-24 h-1 bg-pink-300 mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($services->take(3) as $service)
            <div class="group bg-pink-800/50 backdrop-blur-sm p-10 border-2 border-pink-400/50 hover:border-pink-300 hover:bg-pink-800/70 transition-all duration-500 transform hover:-translate-y-3 rounded-2xl shadow-xl">
                <div class="text-center">
                    <div class="inline-block p-4 bg-pink-700/50 rounded-full mb-6 group-hover:bg-pink-600/50 transition-colors">
                        <i class="fas fa-star text-3xl text-pink-200"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-white">{{ $service->name }}</h3>
                    <p class="text-pink-200 mb-6 leading-relaxed">{{ Str::limit($service->description, 120) }}</p>
                    <div class="mb-6 py-4 border-t border-b border-pink-400/30">
                        <span class="text-4xl font-bold text-white">Rp{{ number_format($service->price, 0) }}</span>
                        <div class="text-pink-300 text-sm mt-2">
                            <i class="far fa-clock mr-1"></i>{{ $service->formatted_duration }}
                        </div>
                    </div>
                    <a href="{{ route('services.show', $service) }}" class="inline-block text-sm border-2 border-pink-200 px-8 py-3 hover:bg-pink-200 hover:text-pink-900 transition-all duration-300 rounded-full uppercase tracking-wider font-semibold">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('services.index') }}" class="inline-block border-2 border-pink-200 px-12 py-4 text-lg font-semibold hover:bg-pink-200 hover:text-pink-900 transition-all duration-300 transform hover:scale-105 rounded-full uppercase tracking-wider shadow-xl">
                Lihat Semua Layanan
            </a>
        </div>
    </div>
</section>
@endif


<!-- CUSTOMER REVIEWS SECTION -->
@if(isset($reviews) && $reviews->count() > 0)
<section class="py-24 bg-gradient-to-b from-pink-50 to-white">
    <div class="container mx-auto px-4">

        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-light mb-6 text-pink-800 tracking-wide">
                APA KATA PELANGGAN KAMI
            </h2>
            <div class="w-24 h-1 bg-pink-500 mx-auto"></div>
        </div>

        @if($reviews->count() > 0)
            <div class="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach($reviews as $review)
                <div class="bg-white shadow-xl hover:shadow-2xl transition-all duration-500 rounded-2xl p-8 border border-pink-100 hover:border-pink-300 transform hover:-translate-y-2">
                    
                    <!-- Rating -->
                    <div class="flex justify-center mb-6 text-2xl">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <span class="text-yellow-400">★</span>
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>

                    <!-- Message -->
                    <p class="text-pink-700 leading-relaxed mb-6 text-center italic">
                        "{{ $review->message }}"
                    </p>

                    <!-- Name -->
                    <h3 class="text-lg font-semibold text-pink-900 text-center">
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
               class="inline-block border-2 border-pink-600 text-pink-600 px-12 py-4 text-lg font-semibold 
                      hover:bg-pink-600 hover:text-white transition-all duration-300 rounded-full uppercase tracking-wider shadow-lg hover:shadow-xl transform hover:scale-105">
                Berikan Ulasan Anda
            </a>
        </div>

    </div>
</section>
@endif



<style>
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(30px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
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