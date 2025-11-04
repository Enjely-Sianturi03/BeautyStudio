@extends('layouts.app')

@section('title', 'Booking - Beauty Studio')

@section('content')
<div class="min-h-screen bg-pink-50 flex justify-center items-center py-10">
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-lg">
        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">💅 Form Booking Beauty Studio</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full p-3 border rounded-lg" placeholder="Masukkan nama anda" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Nomor HP</label>
                <input type="text" name="no_hp" class="w-full p-3 border rounded-lg" placeholder="08xxxxxxxxxx" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Tanggal Booking</label>
                <input type="date" name="tanggal" class="w-full p-3 border rounded-lg" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Layanan</label>
                <select name="layanan" class="w-full p-3 border rounded-lg" required>
                    <option value="">-- Pilih Layanan --</option>
                    <option value="Haircut">Haircut ✂️</option>
                    <option value="Hair Coloring">Hair Coloring 🎨</option>
                    <option value="Manicure">Manicure 💅</option>
                    <option value="Make Up">Make Up 💄</option>
                </select>
            </div>

            <div class="text-center pt-4">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl font-semibold transition duration-300">
                    Booking Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
