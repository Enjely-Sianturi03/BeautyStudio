@extends('layouts.app')

@section('title', 'Contact')

@section('content')

<!-- Load Lucide Icons for aesthetic touch -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<style>
    /* Custom style for the elegant font */
    .font-playfair {
        font-family: 'Playfair Display', serif;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

<!-- <div class="bg-gray-50 min-h-screen pt-24 pb-20"> -->

    <!-- Hero Header Section: Elevated and Glamorous -->
 <section class="relative h-80 bg-gradient-to-r from-pink-700 via-pink-600 to-pink-400 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative z-10 text-center text-white px-6">
        <h1 class="text-5xl font-extrabold tracking-wider">CONTACT & FEEDBACK</h1>
        <p class="text-lg mt-4 opacity-90 max-w-2xl mx-auto">
            Kami selalu senang mendengar pendapat dan pertanyaan Anda ✨
        </p>
    </div>
</section>

<div class="bg-gray-50 min-h-screen pt-24 pb-20">
    <div class="container mx-auto px-4 lg:px-8">

        <!-- Grid Layout for Forms (Sidebar Style) -->
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">

            <!-- SECTION 1 — Form Ulasan (2/3 Lebar) -->
            <div class="lg:col-span-2">
                <section class="bg-white p-8 md:p-12 shadow-2xl rounded-3xl border border-pink-100 mb-12">
                    <div class="flex items-center mb-8 border-b pb-4 border-gray-100">
                        <i data-lucide="star" class="w-7 h-7 text-yellow-500 mr-3 fill-yellow-400"></i>
                        <h2 class="text-3xl font-playfair font-bold text-pink-700">Berikan Ulasan Layanan</h2>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 border border-green-200 shadow-sm">
                            <i data-lucide="check-circle" class="inline w-5 h-5 mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Anda</label>
                                <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap"
                                    class="w-full p-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition shadow-sm"
                                    value="{{ auth()->check() ? auth()->user()->name : '' }}">
                            </div>

                            <div class="mb-4">
                                <label for="rating" class="block text-gray-700 font-medium mb-2">Rating Layanan</label>
                                <select id="rating" name="rating" 
                                    class="w-full p-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition shadow-sm bg-white">
                                    <option value="">Pilih Rating Kepuasan</option>
                                    <option value="5">⭐⭐⭐⭐⭐ - Sangat Memuaskan</option>
                                    <option value="4">⭐⭐⭐⭐ - Memuaskan</option>
                                    <option value="3">⭐⭐⭐ - Cukup Baik</option>
                                    <option value="2">⭐⭐ - Kurang Memuaskan</option>
                                    <option value="1">⭐ - Perlu Perbaikan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="review" class="block text-gray-700 font-medium mb-2">Tulis Ulasan Detail Anda</label>
                            <textarea id="message" name="message" rows="5" placeholder="Bagikan pengalaman terbaik Anda..."
                                class="w-full p-4 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition shadow-sm"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg shadow-pink-300/50 transition transform hover:scale-[1.01]">
                            <i data-lucide="send" class="inline w-5 h-5 mr-2"></i> Kirim Ulasan Bahagia
                        </button>
                    </form>
                </section>
            </div>


            <!-- SECTION 3 — Lokasi & Info Kontak (1/3 Lebar - Sidebar) -->
            <div class="lg:col-span-1">
                <section class="bg-pink-50 p-8 md:p-10 shadow-inner rounded-3xl border border-pink-200 sticky top-28">
                    <div class="flex items-center mb-8 border-b pb-4 border-pink-300">
                        <i data-lucide="map-pin" class="w-7 h-7 text-pink-700 mr-3"></i>
                        <h2 class="text-3xl font-playfair font-bold text-pink-700">Lokasi & Info</h2>
                    </div>

                    <ul class="space-y-6 text-gray-700 mb-8">
                        <li class="flex items-start">
                            <i data-lucide="map" class="w-5 h-5 text-pink-500 flex-shrink-0 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">Alamat Kami</h4>
                                <p class="text-sm">Jl. Jamin Ginting No.444, Padang Bulan, Medan</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="phone" class="w-5 h-5 text-pink-500 flex-shrink-0 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">Telepon</h4>
                                <p class="text-sm">+62 853-7395-7801</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="clock" class="w-5 h-5 text-pink-500 flex-shrink-0 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800">Jam Operasional</h4>
                                <p class="text-sm">Senin - Minggu: 09.00 - 18.00 WIB</p>
                            </div>
                        </li>
                    </ul>

                    <!-- Map Embed Section Baru (Small) -->
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i data-lucide="map" class="w-4 h-4 text-pink-500 mr-2"></i> Lihat di Peta
                    </h4>
                    <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-white ring-2 ring-pink-300/50">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3707.317771873475!2d98.6588382746148!3d3.5584525505010336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303131c259a962bb%3A0x3ab3c5f9a091fbc9!2sJl.%20Jamin%20Ginting%20No.444%2C%20Padang%20Bulan%2C%20Kec.%20Medan%20Baru%2C%20Kota%20Medan%2C%20Sumatera%20Utara%2020157!5e1!3m2!1sid!2sid!4v1765380816858!5m2!1sid!2sid" 
                            width="100%" 
                            height="200" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </section>
            </div>
        </div>
        
        <!-- SECTION 4 — Google Map Full Width sudah dihapus. -->

    </div>
</div>

<script>
    // Initialize lucide icons
    lucide.createIcons();
</script>

@endsection