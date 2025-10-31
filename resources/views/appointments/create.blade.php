@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<!-- Page Header -->
<section class="relative h-64 bg-gradient-to-r from-purple-900 to-pink-900 flex items-center justify-center">
    <div class="text-center text-white px-4">
        <h1 class="text-4xl md:text-5xl font-light mb-2">BOOK YOUR APPOINTMENT</h1>
        <p class="text-lg md:text-xl font-light">Transform your look with our expert stylists</p>
    </div>
</section>

<!-- Booking Form -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 shadow-xl rounded-lg">
            @if(!Auth::check())
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Login Required</h3>
                        <p class="text-blue-800 mb-4">Please login or create an account to book an appointment.</p>
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="inline-block border border-blue-500 text-blue-500 px-6 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                                Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            
            <h2 class="text-3xl font-light mb-8 pb-4 border-b">Appointment Details</h2>

            <form action="{{ route('appointments.store') }}" method="POST" id="appointment-form">
                @csrf

                <!-- Service Selection -->
                <div class="mb-6">
                    <label for="service_id" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Service <span class="text-red-500">*</span>
                    </label>
                    <select name="service_id" id="service_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('service_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Choose a service --</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" 
                                data-price="{{ $service->price }}" 
                                data-duration="{{ $service->duration }}"
                                {{ (old('service_id') == $service->id || ($selectedService && $selectedService->id == $service->id)) ? 'selected' : '' }}>
                            {{ $service->name }} - ${{ number_format($service->price, 2) }} ({{ $service->formatted_duration }})
                        </option>
                        @endforeach
                    </select>
                    @error('service_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service Info Display -->
                <div id="service-info" class="hidden mb-6 p-4 bg-purple-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Price</p>
                            <p class="text-2xl font-light" id="service-price">$0.00</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Duration</p>
                            <p class="text-xl font-light" id="service-duration">0 min</p>
                        </div>
                    </div>
                </div>

                <!-- Stylist Selection -->
                <div class="mb-6">
                    <label for="stylist_id" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Stylist <span class="text-red-500">*</span>
                    </label>
                    <select name="stylist_id" id="stylist_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('stylist_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Choose a stylist --</option>
                        @foreach($stylists as $stylist)
                        <option value="{{ $stylist->id }}" {{ old('stylist_id') == $stylist->id ? 'selected' : '' }}>
                            {{ $stylist->name }} ({{ $stylist->experience_years }} years exp.)
                        </option>
                        @endforeach
                    </select>
                    @error('stylist_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Selection -->
                <div class="mb-6">
                    <label for="appointment_date" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="appointment_date" 
                           id="appointment_date" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ old('appointment_date') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('appointment_date') border-red-500 @enderror"
                           required>
                    @error('appointment_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Selection -->
                <div class="mb-6">
                    <label for="appointment_time" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Time <span class="text-red-500">*</span>
                    </label>
                    <select name="appointment_time" id="appointment_time" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('appointment_time') border-red-500 @enderror"
                            required>
                        <option value="">-- Choose a time --</option>
                        @php
                            $times = [
                                '09:00' => '9:00 AM',
                                '09:30' => '9:30 AM',
                                '10:00' => '10:00 AM',
                                '10:30' => '10:30 AM',
                                '11:00' => '11:00 AM',
                                '11:30' => '11:30 AM',
                                '12:00' => '12:00 PM',
                                '12:30' => '12:30 PM',
                                '13:00' => '1:00 PM',
                                '13:30' => '1:30 PM',
                                '14:00' => '2:00 PM',
                                '14:30' => '2:30 PM',
                                '15:00' => '3:00 PM',
                                '15:30' => '3:30 PM',
                                '16:00' => '4:00 PM',
                                '16:30' => '4:30 PM',
                                '17:00' => '5:00 PM',
                                '17:30' => '5:30 PM',
                                '18:00' => '6:00 PM',
                            ];
                        @endphp
                        @foreach($times as $value => $label)
                        <option value="{{ $value }}" {{ old('appointment_time') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('appointment_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="mb-8">
                    <label for="notes" class="block text-lg font-medium text-gray-700 mb-2">
                        Special Requests / Notes (Optional)
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="Any special requests or notes for your stylist...">{{ old('notes') }}</textarea>
                    @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Maximum 500 characters</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-black text-white px-8 py-4 hover:bg-gray-800 transition font-medium text-lg">
                        <i class="fas fa-check mr-2"></i> CONFIRM BOOKING
                    </button>
                    <a href="{{ route('services.index') }}" 
                       class="flex-1 text-center border-2 border-gray-300 px-8 py-4 hover:bg-gray-100 transition font-medium text-lg">
                        <i class="fas fa-arrow-left mr-2"></i> BACK TO SERVICES
                    </a>
                </div>
            </form>
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Show service info when selected
    document.getElementById('service_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const duration = selectedOption.getAttribute('data-duration');
        const serviceInfo = document.getElementById('service-info');
        
        if (price && duration) {
            document.getElementById('service-price').textContent = '$' + parseFloat(price).toFixed(2);
            document.getElementById('service-duration').textContent = duration + ' min';
            serviceInfo.classList.remove('hidden');
        } else {
            serviceInfo.classList.add('hidden');
        }
    });

    // Trigger change on page load if service is pre-selected
    window.addEventListener('load', function() {
        const serviceSelect = document.getElementById('service_id');
        if (serviceSelect.value) {
            serviceSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection