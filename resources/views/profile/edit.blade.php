@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white shadow-md rounded-2xl p-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1112 21v-2a7 7 0 10-7-7H3a9 9 0 002.121 5.804z" />
            </svg>
            Edit Profile
        </h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Profile Picture --}}
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-indigo-400">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}" 
                        alt="Profile Picture" class="w-full h-full object-cover">
                </div>
                <div>
                    <label for="profile_picture" class="block text-gray-600 font-medium">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" 
                           class="mt-1 block w-full text-sm text-gray-500 border rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="text-xs text-gray-400 mt-1">Maksimal 2MB, format JPG/PNG.</p>
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-medium">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                       class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                       class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-700 font-medium">Password Baru</label>
                <input type="password" name="password" 
                       class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bio / Deskripsi --}}
            <div>
                <label class="block text-gray-700 font-medium">Tentang Saya</label>
                <textarea name="bio" rows="4" 
                          class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                          placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', Auth::user()->bio) }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('profile.show') }}" 
                   class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection