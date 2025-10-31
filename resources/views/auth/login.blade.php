
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<!-- Login Section -->
<section class="min-h-screen flex items-center justify-center py-20 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <h1 class="text-4xl font-serif font-bold text-gray-900 mb-2">ARTIKA SALON</h1>
                </a>
                <p class="text-gray-600 text-lg">Welcome back!</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <div class="p-8 md:p-10">
                    <h2 class="text-3xl font-light text-center mb-8">Login to Your Account</h2>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
                            <p class="text-green-700">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                            <p class="text-red-700 font-semibold mb-2">Whoops! Something went wrong.</p>
                            <ul class="list-disc list-inside text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
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
                                       autocomplete="username"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                       placeholder="your@email.com">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required
                                       autocomplete="current-password"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                       placeholder="Enter your password">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="remember" 
                                       class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-800 hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-black text-white py-3 px-4 rounded-lg hover:bg-gray-800 transition font-medium text-lg flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            LOGIN
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">Or</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-800 font-medium hover:underline">
                                Create one now
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-6 border-t">
                    <p class="text-sm text-gray-600 text-center">
                        <i class="fas fa-lock mr-1 text-gray-400"></i>
                        Your information is secure and encrypted
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection