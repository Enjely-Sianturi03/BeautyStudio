@extends('layouts.app')

@section('title', 'Register - Beauty Studio')

@section('content')
<div class="min-h-screen bg-pink-50 flex justify-center items-center py-10">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Daftar Akun Beauty Studio</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" class="w-full p-3 border rounded-lg" placeholder="Masukkan nama anda" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-3 border rounded-lg" placeholder="Masukkan email" required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Nomor Telepon</label>
                <input type="text" name="telepon" class="w-full p-3 border rounded-lg" placeholder="Masukkan No Telp" required>
                @error('telepon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-3 border rounded-lg" placeholder="Buat password" required>
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full p-3 border rounded-lg" placeholder="Ulangi password" required>
            </div>

            <div class="text-center pt-4">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl font-semibold transition duration-300">
                    Daftar Sekarang
                </button>
            </div>

            <p class="text-center text-gray-600 text-sm mt-4">
                Sudah punya akun? <a href="/login" class="text-pink-600 hover:underline font-semibold">Login di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection


