<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Salon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-pink-600 text-white flex flex-col">
        <div class="p-4 text-center font-bold text-xl border-b border-pink-400">
            ✂️ Salon Management
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="block py-2 px-3 rounded hover:bg-pink-700">Dashboard</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-pink-700">Data Pelanggan</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-pink-700">Data Layanan</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-pink-700">Jadwal Layanan</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-pink-700">Transaksi</a>
            <a href="#" class="block py-2 px-3 rounded hover:bg-pink-700">Laporan</a>
        </nav>
        <div class="p-4 border-t border-pink-400">
            <a href="#" class="block text-center bg-white text-pink-700 py-2 rounded font-semibold hover:bg-pink-100">Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold text-pink-700 mb-6">Dashboard Admin</h1>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white shadow rounded p-4 text-center">
                <h2 class="text-gray-500">Total Pelanggan</h2>
                <p class="text-3xl font-bold text-pink-600">{{ $jumlahPelanggan ?? 120 }}</p>
            </div>
            <div class="bg-white shadow rounded p-4 text-center">
                <h2 class="text-gray-500">Total Layanan</h2>
                <p class="text-3xl font-bold text-pink-600">{{ $jumlahLayanan ?? 10 }}</p>
            </div>
            <div class="bg-white shadow rounded p-4 text-center">
                <h2 class="text-gray-500">Transaksi Hari Ini</h2>
                <p class="text-3xl font-bold text-pink-600">{{ $transaksiHariIni ?? 25 }}</p>
            </div>
            <div class="bg-white shadow rounded p-4 text-center">
                <h2 class="text-gray-500">Pendapatan</h2>
                <p class="text-3xl font-bold text-pink-600">Rp {{ number_format($pendapatan ?? 1250000, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Data Pelanggan -->
        <div class="bg-white shadow rounded p-6 mb-8">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Data Pelanggan</h2>
                <a href="#" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">+ Tambah Pelanggan</a>
            </div>
            <table class="w-full border-collapse">
                <thead class="bg-pink-100">
                    <tr>
                        <th class="border-b py-2 px-3 text-left">Nama</th>
                        <th class="border-b py-2 px-3 text-left">Telepon</th>
                        <th class="border-b py-2 px-3 text-left">Layanan Terakhir</th>
                        <th class="border-b py-2 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-3">Cindy Artika</td>
                        <td class="py-2 px-3">08123456789</td>
                        <td class="py-2 px-3">Hair Spa</td>
                        <td class="py-2 px-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                            <a href="#" class="text-red-600 hover:underline">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-3">Salwa Halila</td>
                        <td class="py-2 px-3">08234567890</td>
                        <td class="py-2 px-3">Facial Treatment</td>
                        <td class="py-2 px-3 text-center">
                            <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                            <a href="#" class="text-red-600 hover:underline">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Laporan Transaksi -->
        <div class="bg-white shadow rounded p-6">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Laporan Transaksi</h2>
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">📄 Export Laporan</button>
            </div>
            <table class="w-full border-collapse">
                <thead class="bg-green-100">
                    <tr>
                        <th class="border-b py-2 px-3 text-left">Tanggal</th>
                        <th class="border-b py-2 px-3 text-left">Pelanggan</th>
                        <th class="border-b py-2 px-3 text-left">Layanan</th>
                        <th class="border-b py-2 px-3 text-right">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-3">2025-11-04</td>
                        <td class="py-2 px-3">Cindy Artika</td>
                        <td class="py-2 px-3">Hair Spa</td>
                        <td class="py-2 px-3 text-right">150.000</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-3">2025-11-04</td>
                        <td class="py-2 px-3">Rohaya Hasibuan</td>
                        <td class="py-2 px-3">Creambath</td>
                        <td class="py-2 px-3 text-right">120.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
