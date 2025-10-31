@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-700 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-light text-white text-center">MY APPOINTMENTS</h1>
    </div>
</section>

<!-- Appointments Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Upcoming Appointments -->
            <div class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-light">Upcoming Appointments</h2>
                    <a href="{{ route('appointments.create') }}" 
                       class="bg-black text-white px-6 py-3 hover:bg-gray-800 transition font-medium">
                        <i class="fas fa-plus mr-2"></i> NEW APPOINTMENT
                    </a>
                </div>

                @if($upcomingAppointments->count() > 0)
                <div class="space-y-6">
                    @foreach($upcomingAppointments as $appointment)
                    <div class="bg-white border-l-4 {{ $appointment->status == 'confirmed' ? 'border-green-500' : 'border-yellow-500' }} p-6 shadow-lg hover:shadow-xl transition rounded-lg">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1 mb-4 md:mb-0">
                                <div class="flex items-center mb-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ strtoupper($appointment->status) }}
                                    </span>
                                </div>
                                
                                <h3 class="text-2xl font-medium mb-2">{{ $appointment->service->name }}</h3>
                                
                                <div class="space-y-2 text-gray-600">
                                    <p class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-3 text-gray-400"></i>
                                        <strong>{{ $appointment->appointment_date->format('l, F d, Y') }}</strong>
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-clock mr-3 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-user-tie mr-3 text-gray-400"></i>
                                        {{ $appointment->stylist->name }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-dollar-sign mr-3 text-gray-400"></i>
                                        ${{ number_format($appointment->service->price, 2) }}
                                    </p>
                                </div>

                                @if($appointment->notes)
                                <div class="mt-3 p-3 bg-gray-50 rounded">
                                    <p class="text-sm text-gray-600">
                                        <strong>Notes:</strong> {{ $appointment->notes }}
                                    </p>
                                </div>
                                @endif
                            </div>

                            <div class="flex flex-col space-y-3 md:ml-6">
                                <a href="{{ route('appointments.show', $appointment) }}" 
                                   class="text-center border-2 border-black px-6 py-2 hover:bg-black hover:text-white transition font-medium">
                                    VIEW DETAILS
                                </a>
                                
                                @if($appointment->canBeCancelled())
                                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full border-2 border-red-500 text-red-500 px-6 py-2 hover:bg-red-500 hover:text-white transition font-medium">
                                        CANCEL
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white p-12 text-center shadow-lg rounded-lg">
                    <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500 mb-6">You don't have any upcoming appointments.</p>
                    <a href="{{ route('appointments.create') }}" 
                       class="inline-block bg-black text-white px-8 py-3 hover:bg-gray-800 transition font-medium">
                        BOOK AN APPOINTMENT
                    </a>
                </div>
                @endif
            </div>

            <!-- Past Appointments -->
            <div>
                <h2 class="text-3xl font-light mb-8">Appointment History</h2>

                @if($pastAppointments->count() > 0)
                <div class="space-y-6 mb-8">
                    @foreach($pastAppointments as $appointment)
                    <div class="bg-white border-l-4 border-gray-300 p-6 shadow-md rounded-lg opacity-75 hover:opacity-100 transition">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $appointment->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ strtoupper($appointment->status) }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-medium mb-2">{{ $appointment->service->name }}</h3>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
                                    <div>
                                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                        {{ $appointment->appointment_date->format('M d, Y') }}
                                    </div>
                                    <div>
                                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    </div>
                                    <div>
                                        <i class="fas fa-user-tie mr-2 text-gray-400"></i>
                                        {{ $appointment->stylist->name }}
                                    </div>
                                    <div>
                                        <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>
                                        ${{ number_format($appointment->service->price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0 md:ml-6">
                                <a href="{{ route('appointments.show', $appointment) }}" 
                                   class="inline-block text-center border border-gray-400 text-gray-600 px-6 py-2 hover:bg-gray-100 transition font-medium text-sm">
                                    VIEW DETAILS
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $pastAppointments->links() }}
                </div>
                @else
                <div class="bg-white p-12 text-center shadow-lg rounded-lg">
                    <i class="fas fa-history text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500">No appointment history yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection