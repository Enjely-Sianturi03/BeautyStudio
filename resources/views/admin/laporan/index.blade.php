@extends('layouts.admin')
@section('title','Laporan Transaksi')
@section('page','Laporan Transaksi')

@section('content')
<div class="bg-white shadow-lg rounded-lg p-6 mb-6 border-l-4 border-pink-500">
  <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
    <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
    </svg>
    Filter Laporan Transaksi
  </h3>

  <form method="GET" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
      
      <!-- Filter Bulan -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan & Tahun</label>
        <input type="month" 
               name="bulan" 
               value="{{ request('bulan', date('Y-m')) }}" 
               class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
      </div>

      <!-- Buttons -->
      <div class="flex gap-2">
        <button type="submit" 
                class="bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-lg px-6 py-2.5 transition duration-200 flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          Filter
        </button>

        <a href="{{ route('admin.laporan.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg px-5 py-2.5 transition duration-200 flex items-center">
          <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          Reset
        </a>
      </div>

      <!-- Export Button -->
      <div class="md:justify-self-end">
        <a href="{{ route('admin.laporan.export', request()->query()) }}" 
           class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg px-6 py-2.5 transition duration-200 flex items-center justify-center w-full md:w-auto">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          Export CSV
        </a>
      </div>

    </div>

    <!-- Info Filter Aktif -->
    @if(request('bulan'))
    <div class="bg-gradient-to-r from-pink-50 to-pink-100 border-l-4 border-pink-500 rounded-lg p-4 flex items-center justify-between">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-pink-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <div>
          <span class="font-semibold text-gray-800">Menampilkan laporan bulan:</span>
          <span class="ml-2 bg-white px-3 py-1 rounded-full text-pink-700 font-bold">
            {{ \Carbon\Carbon::parse(request('bulan'))->locale('id')->isoFormat('MMMM YYYY') }}
          </span>
        </div>
      </div>
      <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
        <span class="text-sm text-gray-600">Total Transaksi:</span>
        <span class="ml-2 text-xl font-bold text-pink-600">
          Rp {{ number_format($total ?? 0, 0, ',', '.') }}
        </span>
      </div>
    </div>
    @else
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 flex items-center">
      <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
      </svg>
      <div>
        <span class="font-semibold text-gray-800">Menampilkan semua transaksi</span>
      </div>
      <div class="ml-auto bg-white rounded-lg px-4 py-2 shadow-sm">
        <span class="text-sm text-gray-600">Total:</span>
        <span class="ml-2 text-xl font-bold text-blue-600">
          Rp {{ number_format($total ?? 0, 0, ',', '.') }}
        </span>
      </div>
    </div>
    @endif

  </form>
</div>

<div class="bg-white shadow-lg rounded-lg overflow-hidden border-l-4 border-pink-500">
  <!-- Header Tabel -->
  <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
    <h4 class="text-white font-bold text-lg flex items-center">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      Data Transaksi
      @if(request('bulan'))
        <span class="ml-2 bg-white text-pink-600 px-3 py-1 rounded-full text-sm">
          {{ \Carbon\Carbon::parse(request('bulan'))->locale('id')->isoFormat('MMMM YYYY') }}
        </span>
      @endif
    </h4>
  </div>

  <!-- Tabel -->
  <div class="p-6">
    @if($data->count() > 0)
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-pink-100">
          <tr>
            <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
            <th class="text-left py-3 px-4 font-semibold text-gray-700">Pelanggan</th>
            <th class="text-left py-3 px-4 font-semibold text-gray-700">Metode Pembayaran</th>
            <th class="text-right py-3 px-4 font-semibold text-gray-700">Total (Rp)</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
          @foreach($data as $appointment)
          @php
              $transaksi = \App\Models\Transaksi::where('user_id', $appointment->user_id)
                            ->where('service_id', $appointment->service_id)
                            ->where('date', $appointment->appointment_jadwal) 
                            ->first();
          @endphp
          <tr class="hover:bg-pink-50 transition duration-150">
            <td class="py-3 px-4 text-gray-700">
              {{ \Carbon\Carbon::parse($appointment->appointment_jadwal)->locale('id')->isoFormat('DD MMMM YYYY') }}
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white font-semibold mr-2">
                  {{ strtoupper(substr($appointment->user->name ?? 'U', 0, 1)) }}
                </div>
                <span class="text-gray-700 font-medium">{{ $appointment->user->name ?? '-' }}</span>
              </div>
            </td>
            <td class="py-3 px-4">
              <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                {{ $appointment->payment_method == 'cash' ? 'bg-green-100 text-green-700' : '' }}
                {{ $appointment->payment_method == 'transfer' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $appointment->payment_method == 'qris' ? 'bg-purple-100 text-purple-700' : '' }}
                {{ !$appointment->payment_method ? 'bg-gray-100 text-gray-700' : '' }}">
                {{ $appointment->payment_method ? strtoupper($appointment->payment_method) : '-' }}
              </span>
            </td>
            <td class="py-3 px-4 text-right font-semibold text-gray-800">
              Rp {{ number_format($appointment->service->harga ?? 0, 0, ',', '.') }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6">{{ $data->links() }}</div>
    @else
    <div class="text-center py-12">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      <p class="text-gray-500 text-lg">Tidak ada data transaksi</p>
      @if(request('bulan'))
      <p class="text-gray-400 text-sm mt-2">untuk bulan {{ \Carbon\Carbon::parse(request('bulan'))->locale('id')->isoFormat('MMMM YYYY') }}</p>
      @endif
    </div>
    @endif
  </div>
</div>
@endsection