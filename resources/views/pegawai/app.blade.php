<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Beauty Studio')</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #fce7f3;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #ec4899, #f43f5e);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #db2777, #e11d48);
        }

        /* Smooth Animations */
        * {
            transition: all 0.3s ease;
        }

        /* Navbar Animation */
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 50%;
            background: linear-gradient(to right, #ec4899, #f43f5e);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Dropdown Animation */
        .dropdown-menu {
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .dropdown:hover .dropdown-menu {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Menu Animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-menu {
            animation: slideDown 0.3s ease;
        }

        /* Background Pattern */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(236, 72, 153, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(244, 63, 94, 0.05) 0%, transparent 50%);
        }

        /* Notification Badge Pulse */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .notification-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 min-h-screen bg-pattern">
    
    {{-- Navigation Bar --}}
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-4 border-pink-500">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-pink-500 to-rose-500 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-spa text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold font-serif bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                            Beauty Studio
                        </h1>
                        <p class="text-xs text-gray-500 font-medium">Your Beauty Partner</p>
                    </div>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('pegawai.dashboard') }}" class="nav-link text-gray-700 hover:text-pink-600 font-medium flex items-center space-x-2 active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('pegawai.jadwal') }}" class="nav-link text-gray-700 hover:text-pink-600 font-medium flex items-center space-x-2">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal</span>
                    </a>
                    <a href="{{ route('pegawai.riwayat') }}" class="nav-link text-gray-700 hover:text-pink-600 font-medium flex items-center space-x-2">
                        <i class="fas fa-history"></i>
                        <span>Riwayat</span>
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative dropdown">
                        <button class="flex items-center space-x-3 bg-gradient-to-r from-pink-50 to-rose-50 px-4 py-2 rounded-xl hover:shadow-md border border-pink-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-500">Pegawai</p>
                            </div>
                            <i class="fas fa-chevron-down text-pink-500"></i>
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div class="dropdown-menu absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl overflow-hidden border border-pink-100">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-4 text-white">
                                <p class="font-semibold">{{ Auth::user()->name ?? 'User' }}</p>
                                <p class="text-xs text-pink-100">{{ Auth::user()->email ?? 'user@email.com' }}</p>
                            </div>
                            <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 flex items-center space-x-3">
                                <i class="fas fa-user-circle text-pink-500"></i>
                                <span>Profil Saya</span>
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 flex items-center space-x-3 font-medium">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-pink-600 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4 mobile-menu">
                <div class="space-y-2">
                    <a href="{{ route('pegawai.dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 rounded-lg flex items-center space-x-3 bg-pink-50">
                        <i class="fas fa-home text-pink-500"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('pegawai.jadwal') }}" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 rounded-lg flex items-center space-x-3">
                        <i class="fas fa-calendar-alt text-pink-500"></i>
                        <span class="font-medium">Jadwal</span>
                    </a>
                    <a href="{{ route('pegawai.riwayat') }}" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 rounded-lg flex items-center space-x-3">
                        <i class="fas fa-history text-pink-500"></i>
                        <span class="font-medium">Riwayat</span>
                    </a>
                    <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 rounded-lg flex items-center space-x-3">
                        <i class="fas fa-bell text-pink-500"></i>
                        <span class="font-medium">Notifikasi</span>
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-auto">3</span>
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 rounded-lg flex items-center space-x-3">
                        <i class="fas fa-user-circle text-pink-500"></i>
                        <span class="font-medium">Profil Saya</span>
                    </a>
                    <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-pink-50 rounded-lg flex items-center space-x-3">
                        <i class="fas fa-cog text-pink-500"></i>
                        <span class="font-medium">Pengaturan</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg flex items-center space-x-3 font-medium">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white mt-12 border-t-4 border-pink-500">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- About --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-500 p-3 rounded-xl">
                            <i class="fas fa-spa text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-serif bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                            Beauty Studio
                        </h3>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Memberikan layanan kecantikan terbaik dengan profesionalisme dan dedikasi tinggi untuk kepuasan pelanggan.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center text-white hover:shadow-lg transform hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center text-white hover:shadow-lg transform hover:scale-110">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center text-white hover:shadow-lg transform hover:scale-110">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-link text-pink-500 mr-2"></i>
                        Quick Links
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-pink-600 flex items-center"><i class="fas fa-chevron-right text-pink-400 mr-2 text-xs"></i>Dashboard</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-pink-600 flex items-center"><i class="fas fa-chevron-right text-pink-400 mr-2 text-xs"></i>Jadwal</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-pink-600 flex items-center"><i class="fas fa-chevron-right text-pink-400 mr-2 text-xs"></i>Riwayat</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-pink-600 flex items-center"><i class="fas fa-chevron-right text-pink-400 mr-2 text-xs"></i>Bantuan</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-phone text-pink-500 mr-2"></i>
                        Kontak
                    </h4>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-pink-500 mr-3 mt-1"></i>
                            <span>Jl. Kecantikan No. 123, Medan</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-pink-500 mr-3"></i>
                            <span>info@beautystudio.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-pink-500 mr-3"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-8 pt-6 text-center">
                <p class="text-gray-600">
                    © 2024 <span class="font-semibold text-pink-600">Beauty Studio</span>. All rights reserved. Made with 
                    <i class="fas fa-heart text-pink-500 mx-1"></i> for beauty
                </p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                }
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>