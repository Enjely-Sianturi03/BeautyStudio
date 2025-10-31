@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<!-- Forgot Password Section -->
<section class="min-h-screen flex items-center justify-center py-20 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <h1 class="text-4xl font-serif font-bold text-gray-900 mb-2">ARTIKA SALON</h1>
                </a>
                <p class="text-gray-600 text-lg">Reset your password</p>
            </div>

            <!-- Forgot Password Card -->
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <div class="p-8 md:p-10">
                    <div class="text-center mb-8">
                        <div class="inline-block p-4 bg-purple-100 rounded-full mb-4">
                            <i class="fas fa-key text-4xl text-purple-600"></i>
                        </div>
                        <h2 class="text-3xl font-light mb-2">Forgot Password?</h2>
                        <p class="text-gray-600">
                            No problem. Just let us know your email address and we'll email you a password reset link.
                        </p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
                            <div class="flex">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <p class="text-green-700">{{ session('status') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                            <ul class="list-disc list-inside text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                       placeholder="your@email.com">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-black text-white py-3 px-4 rounded-lg hover:bg-gray-800 transition font-medium text-lg flex items-center justify-center mb-4">
                            <i class="fas fa-paper-plane mr-2"></i>
                            SEND RESET LINK
                        </button>

                        <!-- Back to Login -->
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center border-2 border-gray-300 py-3 px-4 rounded-lg hover:bg-gray-100 transition font-medium text-lg">
                            <i class="fas fa-arrow-left mr-2"></i>
                            BACK TO LOGIN
                        </a>
                    </form>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-6 border-t">
                    <p class="text-sm text-gray-600 text-center">
                        <i class="fas fa-info-circle mr-1 text-gray-400"></i>
                        Check your spam folder if you don't receive the email
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-home mr-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection