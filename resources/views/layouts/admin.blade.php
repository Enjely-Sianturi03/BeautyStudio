<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard Admin Salon')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50 flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-pink-300 text-white flex flex-col shadow-lg">
    <div class="p-4 text-center font-bold text-xl border-b border-pink-200">
      ✂️ Salon Management
    </div>
    <nav class="flex-1 p-4 space-y-2">
      <!-- Ganti href="#" dengan route() Laravel -->
      <a href="{{ route('admin.dashboard') }}"
         class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.dashboard') ? 'bg-pink-500' : '' }}">
         Dashboard
      </a>
      <a href="{{ route('admin.pelanggan.index') }}"
         class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.pelanggan.*') ? 'bg-pink-500' : '' }}">
         Manajemen User
      </a>
      <a href="{{ route('admin.layanan.index') }}"
         class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.layanan.*') ? 'bg-pink-500' : '' }}">
         Data Layanan
      </a>
      <a href="{{ route('admin.jadwal.index') }}"
         class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.jadwal.*') ? 'bg-pink-500' : '' }}">
         Jadwal Layanan
      </a>
      <a href="{{ route('admin.transaksi.index') }}"
         class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.transaksi.*') ? 'bg-pink-500' : '' }}">
         Transaksi
      </a>
      <a href="{{ route('admin.laporan.index') }}"
         class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.laporan.*') ? 'bg-pink-500' : '' }}">
         Laporan
      </a>
      <a href="{{ route('admin.reviews.index') }}"
        class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.review.*') ? 'bg-pink-500' : '' }}">
        Review
      </a>
      <a href="{{ route('admin.tipsartikel.index') }}"
        class="block py-2 px-3 rounded hover:bg-pink-400 {{ request()->routeIs('admin.tips.*') ? 'bg-pink-500' : '' }}">
        Tips & Artikel
      </a>


    </nav>

    <!-- Tombol Logout -->
    <div class="p-4 border-t border-pink-200">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="w-full text-center bg-white text-pink-600 py-2 rounded font-semibold hover:bg-pink-100">
          Logout
        </button>
      </form>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8 overflow-y-auto bg-pink-100">
    <h1 class="text-3xl font-bold text-pink-700 mb-6">@yield('page', 'Dashboard Admin')</h1>

    @if(session('ok'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('ok') }}</div>
    @endif

    @yield('content')
  </main>
</body>
</html>
