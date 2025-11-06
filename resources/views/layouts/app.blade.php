<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Beauty Studio') }} - @yield('title', 'Modern Artistic Hair')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<<<<<<< HEAD
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
=======
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js for interactive UI -->
>>>>>>> 7831b29bf5c26abc5d2b7033d5a5584c173ab7a4
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white shadow-md transition-all duration-300" id="navbar">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-serif font-bold text-gray-900 hover:text-gray-700 transition">
                    BEAUTY STUDIO
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('home') ? 'border-b-2 border-gray-900' : '' }}">HOME</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('services.*') ? 'border-b-2 border-gray-900' : '' }}">SERVICES</a>
                    
                    {{-- <a href="{{ route('gallery.index') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('gallery.*') ? 'border-b-2 border-gray-900' : '' }}">GALLERY</a> --}}
                    
                    <a href="#contact" class="text-gray-700 hover:text-gray-900 transition font-medium">CONTACT</a>

                    @auth
                        <a href="{{ route('appointments.index') }}" class="text-gray-700 hover:text-gray-900 transition font-medium {{ request()->routeIs('appointments.*') ? 'border-b-2 border-gray-900' : '' }}">MY APPOINTMENTS</a>
                        <a href="{{ route('appointments.create') }}" class="bg-black text-white px-6 py-2 hover:bg-gray-800 transition font-medium">
                            BOOK NOW
                        </a>

                        <!-- Dropdown Menu -->
                        <div x-data="{ open: false }" class="relative">
                            @php
                                $user = Auth::user();
                                $profilePicture = $user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture))
                                    ? asset('storage/' . $user->profile_picture)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random';
                            @endphp

                            <button 
                                @click="open = !open" 
                                class="flex items-center text-gray-700 hover:text-gray-900 transition font-medium focus:outline-none"
                            >
                                <img 
                                    src="{{ $profilePicture }}" 
                                    alt="Profile Picture" 
                                    class="w-8 h-8 rounded-full object-cover border border-gray-300 mr-2"
                                >
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div 
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-150" 
                                x-transition:enter-start="opacity-0 scale-95" 
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                @click.away="open = false"
                                x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                            >
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 transition font-medium">LOGIN</a>
                        <a href="{{ route('appointments.create') }}" class="bg-black text-white px-6 py-2 hover:bg-gray-800 transition font-medium">
                            BOOK NOW
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700 hover:text-gray-900" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white border-t" id="mobile-menu">
            <div class="container mx-auto px-4 py-4 space-y-4">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">HOME</a>
                <a href="{{ route('services.index') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">SERVICES</a>
                
                {{-- <a href="{{ route('gallery.index') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">GALLERY</a> --}}
                
                <a href="#contact" class="block text-gray-700 hover:text-gray-900 transition font-medium">CONTACT</a>

                @auth
                    <a href="{{ route('appointments.index') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">MY APPOINTMENTS</a>
                    <a href="{{ route('profile.edit') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">PROFILE</a>
                    <a href="{{ route('appointments.create') }}" class="block bg-black text-white px-6 py-2 text-center hover:bg-gray-800 transition font-medium">
                        BOOK NOW
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left text-gray-700 hover:text-gray-900 transition font-medium">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">LOGIN</a>
                    <a href="{{ route('register') }}" class="block text-gray-700 hover:text-gray-900 transition font-medium">REGISTER</a>
                    <a href="{{ route('appointments.create') }}" class="block bg-black text-white px-6 py-2 text-center hover:bg-gray-800 transition font-medium">
                        BOOK NOW
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 container mx-auto mt-4" role="alert">
                <p class="font-bold">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 container mx-auto mt-4" role="alert">
                <p class="font-bold">Error!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-12">

                <!-- About -->
                <div>
                    <h3 class="text-2xl font-serif mb-4">Beauty Studio</h3>
                    <p class="text-gray-400 mb-4">A destination salon in Whittier, CA known for customer service and sensory experience.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f text-xl"></i></a>
                        <a href="https://instagram.com/artikahairspa" target="_blank" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">QUICK LINKS</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('services.index') }}" class="text-gray-400 hover:text-white transition">Services</a></li>
                        {{-- <li><a href="{{ route('gallery.index') }}" class="text-gray-400 hover:text-white transition">Gallery</a></li> --}}
                        <li><a href="{{ route('appointments.create') }}" class="text-gray-400 hover:text-white transition">Book Appointment</a></li>
                        @auth
                        <li><a href="{{ route('appointments.index') }}" class="text-gray-400 hover:text-white transition">My Appointments</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">CONTACT</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt mr-3 mt-1"></i><span>123 Main Street<br>Whittier, CA 90601</span></li>
                        <li class="flex items-center"><i class="fas fa-phone mr-3"></i><span>(562) 555-1234</span></li>
                        <li class="flex items-center"><i class="fas fa-envelope mr-3"></i><span>info@artikasalon.com</span></li>
                    </ul>
                </div>

                <!-- Hours -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">HOURS</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex justify-between"><span>Monday - Friday</span><span>9:00 AM - 7:00 PM</span></li>
                        <li class="flex justify-between"><span>Saturday</span><span>9:00 AM - 6:00 PM</span></li>
                        <li class="flex justify-between"><span>Sunday</span><span>Closed</span></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800">
                <h4 class="text-lg font-semibold mb-3">REFUND POLICY</h4>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Due to the time and product used that goes into your custom service, ARTIKA Hair Spa does not offer refunds. 
                    We do offer adjustments to technical errors such as uneven haircuts, uneven hair color, bleed marks on hair color. 
                    Any errors need to be brought to our attention within 72 hours of your appointment.
                </p>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Beauty Studio. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
<<<<<<< HEAD
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
=======
        mobileMenuButton.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

        // Navbar scroll effect
>>>>>>> 7831b29bf5c26abc5d2b7033d5a5584c173ab7a4
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) navbar.classList.add('shadow-lg');
            else navbar.classList.remove('shadow-lg');
        });
<<<<<<< HEAD
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
=======

        // Auto hide alerts
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
>>>>>>> 7831b29bf5c26abc5d2b7033d5a5584c173ab7a4
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
