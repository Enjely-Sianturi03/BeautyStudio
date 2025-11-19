<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Beauty Studio') }} - @yield('title', 'Modern Artistic Hair')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { font-family: 'Montserrat', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }

        .bg-primary { background-color: #fe76b3ff !important; }
        .bg-primary-dark { background-color: #ff8fc1ff !important; }
        .text-primary { color: #fe76b3ff !important; }
        .hover\:text-primary-dark:hover { color: #f878b2ff !important; }
        .hover\:bg-primary-dark:hover { background-color: #ff87bdff !important; }
        .border-primary { border-color: #fe76b3ff !important; }
        .hover\:bg-pink-100:hover { background-color: #ffe4f1 !important; }
    </style>
</head>

<body class="antialiased bg-pink-100">

    <!-- Navigation -->
    <nav id="navbar" class="fixed w-full z-50 bg-pink-100 shadow-md transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-4xl font-serif font-bold text-primary hover:text-primary-dark transition">
                    BEAUTY STUDIO
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
<<<<<<< HEAD
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('home') ? 'border-b-2 border-gray-900' : '' }}">HOME</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('services.*') ? 'border-b-2 border-gray-900' : '' }}">SERVICES</a>
                    
                    {{-- <a href="{{ route('gallery.index') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('gallery.*') ? 'border-b-2 border-gray-900' : '' }}">GALLERY</a> --}}
                    
                    <a href="#contact" class="text-gray-700 hover:text-gray-900 transition font-medium">CONTACT</a>
=======

                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-primary transition font-medium
                        {{ request()->routeIs('home') ? 'border-b-2 border-primary' : '' }}">
                        HOME
                    </a>

                    <a href="{{ route('tips.index') }}"
                        class="text-gray-700 hover:text-primary transition font-medium
                        {{ request()->routeIs('tips.*') ? 'border-b-2 border-primary' : '' }}">
                        TIPS
                    </a>

                    <a href="{{ route('contact') }}" 
                        class="text-gray-700 hover:text-primary transition font-medium
                        {{ request()->routeIs('contact') ? 'border-b-2 border-primary' : '' }}">
                        CONTACT
                    </a>
>>>>>>> b9d34b37e7669b20fccced3889299141d3f4c5a0

                    @auth
                        <a href="{{ route('appointments.index') }}"
                            class="text-gray-700 hover:text-primary transition font-medium
                            {{ request()->routeIs('appointments.*') ? 'border-b-2 border-primary' : '' }}">
                            MY APPOINTMENTS
                        </a>

                        <a href="{{ route('appointments.create') }}" class="bg-primary text-white px-6 py-2 hover:bg-primary-dark transition font-medium">
                            BOOK NOW
                        </a>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">

                            @php
                                $user = Auth::user();
                                $profilePicture = $user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture))
                                    ? asset('storage/' . $user->profile_picture)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random';
                            @endphp

                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-primary transition font-medium">
                                <img src="{{ $profilePicture }}" class="w-8 h-8 rounded-full border mr-2" alt="Profile">
                                <span>{{ $user->name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div x-show="open" x-cloak
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">

                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-pink-100">
                                    Profile
                                </a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-pink-100">
                                        Logout
                                    </button>
                                </form>

                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition font-medium">LOGIN</a>
                        <a href="{{ route('appointments.create') }}" class="bg-primary text-white px-6 py-2 hover:bg-primary-dark transition font-medium">
                            BOOK NOW
                        </a>
                    @endauth
                </div>

                <!-- Mobile Button -->
                <button id="mobile-menu-button" class="md:hidden text-primary hover:text-primary-dark">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="container mx-auto px-4 py-4 space-y-4">
<<<<<<< HEAD
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">HOME</a>
                <a href="{{ route('services.index') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">SERVICES</a>
                
                {{-- <a href="{{ route('gallery.index') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">GALLERY</a> --}}
                
                <a href="#contact" class="block text-gray-700 hover:text-gray-900 transition font-medium">CONTACT</a>
=======

                <a href="{{ route('home') }}" class="block text-primary font-medium">HOME</a>
                <a href="{{ route('tips.index') }}" class="block text-gray-700 hover:text-primary">TIPS</a>
                <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-primary">CONTACT</a>
>>>>>>> b9d34b37e7669b20fccced3889299141d3f4c5a0

                @auth
                    <a href="{{ route('appointments.index') }}" class="block">MY APPOINTMENTS</a>
                    <a href="{{ route('profile.edit') }}" class="block">PROFILE</a>

                    <a href="{{ route('appointments.create') }}" class="block bg-primary text-white px-6 py-2 text-center rounded">
                        BOOK NOW
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="block w-full text-left">LOGOUT</button>
                    </form>

                @else
                    <a href="{{ route('login') }}" class="block">LOGIN</a>
                    <a href="{{ route('register') }}" class="block">REGISTER</a>

                    <a href="{{ route('appointments.create') }}" class="block bg-primary text-white px-6 py-2 text-center rounded">
                        BOOK NOW
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-primary-dark text-white py-16">
        <div class="container mx-auto px-4">

            <div class="grid md:grid-cols-4 gap-8 mb-12">

                <!-- About -->
                <div>
                    <h3 class="text-2xl mb-4">Beauty Studio</h3>
                    <p class="text-pink-100 mb-4">A destination salon in Whittier, CA known for customer service and sensory experience.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-pink-200 hover:text-white"><i class="fab fa-facebook-f text-xl"></i></a>
                        <a href="https://instagram.com/artikahairspa" target="_blank" class="text-pink-200 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-pink-200 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">QUICK LINKS</h4>
                    <ul class="space-y-2">
<<<<<<< HEAD
                        <li><a href="{{ route('services.index') }}" class="text-gray-400 hover:text-white transition">Services</a></li>
                        {{-- <li><a href="{{ route('gallery.index') }}" class="text-gray-400 hover:text-white transition">Gallery</a></li> --}}
                        <li><a href="{{ route('appointments.create') }}" class="text-gray-400 hover:text-white transition">Book Appointment</a></li>
=======
                        <li><a href="{{ route('services.index') }}" class="text-pink-100 hover:text-white">Services</a></li>
                        <li><a href="{{ route('tips.index') }}" class="text-pink-100 hover:text-white">Tips</a></li>
                        <li><a href="{{ route('appointments.create') }}" class="text-pink-100 hover:text-white">Book Appointment</a></li>

>>>>>>> b9d34b37e7669b20fccced3889299141d3f4c5a0
                        @auth
                        <li><a href="{{ route('appointments.index') }}" class="text-pink-100 hover:text-white">My Appointments</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">CONTACT</h4>
                    <ul class="space-y-3 text-pink-100">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt mr-3"></i>123 Main Street, Whittier, CA 90601</li>
                        <li class="flex items-center"><i class="fas fa-phone mr-3"></i>(562) 555-1234</li>
                        <li class="flex items-center"><i class="fas fa-envelope mr-3"></i>info@artikasalon.com</li>
                    </ul>
                </div>

                <!-- Hours -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">HOURS</h4>
                    <ul class="space-y-2 text-pink-100">
                        <li class="flex justify-between"><span>Mon - Fri</span><span>9 AM - 7 PM</span></li>
                        <li class="flex justify-between"><span>Saturday</span><span>9 AM - 6 PM</span></li>
                        <li class="flex justify-between"><span>Sunday</span><span>Closed</span></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-pink-300">
                <h4 class="text-lg font-semibold mb-3">REFUND POLICY</h4>
                <p class="text-sm text-pink-100">
                    Due to the time and product used, ARTIKA Hair Spa does not offer refunds.
                    We only offer adjustments for technical errors (uneven cuts, uneven color, etc.)
                    reported within 72 hours.
                </p>
            </div>

            <div class="mt-8 pt-8 border-t border-pink-300 text-center text-pink-100">
                <p>&copy; {{ date('Y') }} Beauty Studio. All rights reserved.</p>
            </div>

        </div>
    </footer>

<<<<<<< HEAD
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) navbar.classList.add('shadow-lg');
            else navbar.classList.remove('shadow-lg');
        });


        // Auto hide alerts
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
=======
<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuButton.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('navbar');
        navbar.classList.toggle('shadow-lg', window.scrollY > 50);
    });
</script>

@stack('scripts')
>>>>>>> b9d34b37e7669b20fccced3889299141d3f4c5a0

</body>
</html>
