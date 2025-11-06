@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4">
    <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Profil Saya</h2>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300 text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-2xl shadow-xl transition duration-300 hover:shadow-2xl">
        <div class="flex flex-col sm:flex-row items-center sm:items-start sm:space-x-8 mb-6">
            {{-- Foto profil --}}
            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-indigo-500 shadow-md">
                @php
                    $profilePath = 'storage/' . $user->profile_picture;
                @endphp

                @if ($user->profile_picture && file_exists(public_path($profilePath)))
                    <img src="{{ asset($profilePath) }}" 
                         alt="Profile Picture" 
                         class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=128" 
                         alt="Default Avatar" 
                         class="w-full h-full object-cover">
                @endif
            </div>

            {{-- Info pengguna --}}
            <div class="mt-6 sm:mt-0 text-center sm:text-left flex-1">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-600 text-sm mb-3">{{ $user->email }}</p>

                @if($user->bio)
                    <p class="text-gray-700 leading-relaxed italic border-l-4 border-indigo-400 pl-3">“{{ $user->bio }}”</p>
                @else
                    <p class="text-gray-400 italic">Belum ada deskripsi tentang diri kamu.</p>
                @endif
            </div>
        </div>

        <div class="flex justify-end border-t pt-4 mt-4">
            <a href="{{ route('profile.edit') }}" 
               class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                ✏️ Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
