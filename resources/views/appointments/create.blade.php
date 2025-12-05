@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<!-- Page Header -->
<section class="relative h-64 bg-gradient-to-r from-pink-700 to-pink-900 flex items-center justify-center">
    <div class="text-center text-white px-4">
        <h1 class="text-4xl md:text-5xl font-light mb-2">BOOK YOUR APPOINTMENT</h1>
        <p class="text-lg md:text-xl font-light">Transform your look with our expert stylists</p>
    </div>
</section>

<!-- Booking Form -->
<section class="py-20 bg-pink-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-pink-100 p-8 md:p-12 shadow-xl rounded-lg">
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

            @php
                $selected = $selectedService ?? $service ?? null;
                $times = [
                    '09:00' => '9:00 AM', '09:30' => '9:30 AM', '10:00' => '10:00 AM', '10:30' => '10:30 AM',
                    '11:00' => '11:00 AM', '11:30' => '11:30 AM', '12:00' => '12:00 PM', '12:30' => '12:30 PM',
                    '13:00' => '1:00 PM', '13:30' => '1:30 PM', '14:00' => '2:00 PM', '14:30' => '2:30 PM',
                    '15:00' => '3:00 PM', '15:30' => '3:30 PM', '16:00' => '4:00 PM', '16:30' => '4:30 PM',
                    '17:00' => '5:00 PM', '17:30' => '5:30 PM', '18:00' => '6:00 PM'
                ];
                $minDate = date('Y-m-d', strtotime('+1 day'));
            @endphp

            <h2 class="text-3xl font-light mb-8 pb-4 border-b">Appointment Details</h2>

            <form action="{{ route('appointments.store') }}" 
                  method="POST" 
                  id="appointment-form" 
                  enctype="multipart/form-data">
                @csrf

                <!-- Service Selection -->
                <div class="mb-6">
                    <label for="service_id" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Service <span class="text-red-500">*</span>
                    </label>

                    @if($selected)
                        <input type="text" value="{{ $selected->name }}" disabled
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 mb-2">
                        <input type="hidden" name="service_id" id="service_id" value="{{ $selected->id }}"
                               data-price="{{ $selected->price ?? '' }}"
                               data-duration="{{ $selected->duration ?? '' }}">
                    @else
                        <select name="service_id" id="service_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('service_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Choose a service --</option>
                            @foreach($services as $srv)
                                <option value="{{ $srv->id }}"
                                        data-price="{{ $srv->price }}"
                                        data-duration="{{ $srv->duration }}"
                                        {{ old('service_id') == $srv->id ? 'selected' : '' }}>
                                    {{ $srv->name }} - ${{ number_format($srv->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    @endif

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

                <!-- Date Selection -->
                <div class="mb-6">
                    <label for="jadwal" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="jadwal" 
                           id="appointment_date" 
                           min="{{ $minDate }}"
                           value="{{ old('jadwal') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('jadwal') border-red-500 @enderror"
                           required>
                    @error('jadwal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Selection -->
                <div class="mb-6">
                    <label for="jam_mulai" class="block text-lg font-medium text-gray-700 mb-2">
                        Select Time <span class="text-red-500">*</span>
                    </label>
                    <select name="jam_mulai" id="appointment_time"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('jam_mulai') border-red-500 @enderror"
                            required>
                        <option value="">-- Choose a time --</option>
                        @foreach($times as $value => $label)
                            <option value="{{ $value }}" {{ old('jam_mulai') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('jam_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Payment Method <span class="text-red-500">*</span></label>
                    <select name="payment_method" class="w-full border rounded-lg px-3 py-2 @error('payment_method') border-red-500 @enderror" required>
                        <option value="">-- Choose a payment method --</option>
                        <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="DANA" {{ old('payment_method') == 'DANA' ? 'selected' : '' }}>DANA</option>
                        <option value="OVO" {{ old('payment_method') == 'OVO' ? 'selected' : '' }}>OVO</option>
                        <option value="ShopeePay" {{ old('payment_method') == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                        <option value="GOPAY" {{ old('payment_method') == 'GOPAY' ? 'selected' : '' }}>GOPAY</option>
                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Payment Proof -->
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Upload Payment Proof</label>
                    <input type="file" 
                           name="payment_proof" 
                           accept="image/*"
                           class="w-full border rounded-lg px-3 py-2 @error('payment_proof') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Upload JPG/PNG. Max 2MB. If you choose Cash, upload optional.</p>
                    @error('payment_proof')
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
                            class="flex-1 bg-pink-600 text-white px-8 py-4 hover:bg-pink-500 transition font-medium text-lg">
                        <i class="fas fa-check mr-2"></i> CONFIRM BOOKING
                    </button>
                    <a href="{{ route('home') }}" 
                       class="flex-1 text-center border-2 border-gray-300 px-8 py-4 hover:bg-gray-100 transition font-medium text-lg">
                        <i class="fas fa-arrow-left mr-2"></i> BACK TO HOME
                    </a>
                </div>
            </form>
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
    function showServiceInfo(el) {
        const option = el.tagName.toLowerCase() === 'select' ? el.options[el.selectedIndex] : el;
        const price = option.getAttribute('data-price') || '';
        const duration = option.getAttribute('data-duration') || '';
        const serviceInfo = document.getElementById('service-info');
        if(price && duration) {
            document.getElementById('service-price').textContent = '$' + parseFloat(price).toFixed(2);
            document.getElementById('service-duration').textContent = duration + ' min';
            serviceInfo.classList.remove('hidden');
        } else serviceInfo.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        if(serviceSelect) {
            if(serviceSelect.tagName.toLowerCase() === 'select') {
                serviceSelect.addEventListener('change', function(){ showServiceInfo(this); });
                if(serviceSelect.value) showServiceInfo(serviceSelect);
            } else showServiceInfo(serviceSelect);
        }

        const paymentMethod = document.querySelector('select[name="payment_method"]');
        const paymentProof = document.querySelector('input[name="payment_proof"]');
        if(paymentMethod && paymentProof){
            function toggleProofRequirement(){
                if(paymentMethod.value === 'Cash') paymentProof.removeAttribute('required');
                else paymentProof.setAttribute('required','required');
            }
            paymentMethod.addEventListener('change', toggleProofRequirement);
            toggleProofRequirement();
        }
    });
</script>
@endpush
@endsection
