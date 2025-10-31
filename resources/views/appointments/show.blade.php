@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-purple-900 to-pink-900 py-12">
    <div class="container mx-auto px-4">
        <div class="text-center text-white">
            <h1 class="text-3xl md:text-4xl font-light mb-2">APPOINTMENT DETAILS</h1>
            <p class="text-lg">Booking #{{ $appointment->id }}</p>
        </div>
    </div>
</section>

<!-- Appointment Details -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('appointments.index') }}" class="text-gray-500 hover:text-gray-700">My Appointments</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900">Appointment #{{ $appointment->id }}</span>
            </nav>

            <!-- Status Banner -->
            <div class="mb-8">
                @if($appointment->status == 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6">
                    <div class="flex">
                        <i class="fas fa-clock text-yellow-400 text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900 mb-1">Pending Confirmation</h3>
                            <p class="text-yellow-800">Your appointment is pending confirmation. We'll contact you shortly to confirm your booking.</p>
                        </div>
                    </div>
                </div>
                @elseif($appointment->status == 'confirmed')
                <div class="bg-green-50 border-l-4 border-green-500 p-6">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-500 text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-green-900 mb-1">Appointment Confirmed!</h3>
                            <p class="text-green-800">Your appointment has been confirmed. We look forward to seeing you!</p>
                        </div>
                    </div>
                </div>
                @elseif($appointment->status == 'completed')
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6">
                    <div class="flex">
                        <i class="fas fa-check-double text-blue-500 text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900 mb-1">Completed</h3>
                            <p class="text-blue-800">Thank you for visiting us! We hope you loved your new look.</p>
                        </div>
                    </div>
                </div>
                @elseif($appointment->status == 'cancelled')
                <div class="bg-red-50 border-l-4 border-red-500 p-6">
                    <div class="flex">
                        <i class="fas fa-times-circle text-red-500 text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-red-900 mb-1">Cancelled</h3>
                            <p class="text-red-800">This appointment has been cancelled.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Appointment Card -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-gray-900 to-gray-700 p-8 text-white">
                    <h2 class="text-3xl font-light mb-2">{{ $appointment->service->name }}</h2>
                    <p class="text-gray-300">{{ $appointment->appointment_date->format('l, F d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                </div>

                <!-- Body -->
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <!-- Service Details -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Service Details</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-cut text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Service</p>
                                        <p class="font-medium">{{ $appointment->service->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Duration</p>
                                        <p class="font-medium">{{ $appointment->service->formatted_duration }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-dollar-sign text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Price</p>
                                        <p class="font-medium text-2xl">${{ number_format($appointment->service->price, 2) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-tag text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Category</p>
                                        <p class="font-medium capitalize">{{ $appointment->service->category }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Info -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Appointment Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Date</p>
                                        <p class="font-medium">{{ $appointment->appointment_date->format('l, F d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Time</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-user-tie text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Stylist</p>
                                        <p class="font-medium">{{ $appointment->stylist->name }}</p>
                                        @if($appointment->stylist->experience_years)
                                        <p class="text-sm text-gray-500">{{ $appointment->stylist->experience_years }} years experience</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-gray-400 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                                            {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $appointment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $appointment->status == 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $appointment->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($appointment->notes)
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Your Notes</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if($appointment->admin_notes && Auth::user()->isAdmin())
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 pb-2 border-b">Admin Notes</h3>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $appointment->admin_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Service Description -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 pb-2 border-b">About This Service</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $appointment->service->description }}</p>
                    </div>

                    <!-- Location Info -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Salon Location</h3>
                        <div class="space-y-3 text-gray-700">
                            <p class="flex items-start">
                                <i class="fas fa-map-marker-alt mr-3 mt-1 text-gray-400"></i>
                                <span>123 Main Street, Whittier, CA 90601</span>
                            </p>
                            <p class="flex items-center">
                                <i class="fas fa-phone mr-3 text-gray-400"></i>
                                <a href="tel:5621234567" class="hover:underline">(562) 123-4567</a>
                            </p>
                            <p class="flex items-center">
                                <i class="fas fa-envelope mr-3 text-gray-400"></i>
                                <a href="mailto:info@artikasalon.com" class="hover:underline">info@artikasalon.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-gray-50 p-8 border-t">
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <a href="{{ route('appointments.index') }}" 
                           class="flex-1 text-center border-2 border-gray-400 px-6 py-3 hover:bg-gray-100 transition font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> BACK TO APPOINTMENTS
                        </a>
                        
                        @if($appointment->canBeCancelled())
                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Are you sure you want to cancel this appointment? This action cannot be undone.');">
                            @csrf
                            <button type="submit" 
                                    class="w-full border-2 border-red-500 text-red-500 px-6 py-3 hover:bg-red-500 hover:text-white transition font-medium">
                                <i class="fas fa-times mr-2"></i> CANCEL APPOINTMENT
                            </button>
                        </form>
                        @endif
                        
                        @if($appointment->status == 'completed')
                        <a href="{{ route('appointments.create') }}" 
                           class="flex-1 text-center bg-black text-white px-6 py-3 hover:bg-gray-800 transition font-medium">
                            <i class="fas fa-plus mr-2"></i> BOOK ANOTHER
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            @if(in_array($appointment->status, ['pending', 'confirmed']))
            <div class="mt-8 bg-blue-50 border border-blue-200 p-6 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-3">Important Information</h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-check mr-2 mt-1"></i>
                        <span>Please arrive 10 minutes before your scheduled time</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check mr-2 mt-1"></i>
                        <span>Complimentary wellness ritual included with your service</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check mr-2 mt-1"></i>
                        <span>Cancellations must be made at least 24 hours in advance</span>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection