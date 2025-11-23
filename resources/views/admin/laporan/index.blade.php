@extends('layouts.admin')
@section('title','Laporan Transaksi')
@section('page','Laporan Transaksi')

@section('content')
<form method="GET" class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400 grid grid-cols-1 md:grid-cols-5 gap-3">
  
  <input type="date" name="from" value="{{ $from?->format('Y-m-d') }}" class="p-2 border rounded">
  <input type="date" name="to" value="{{ $to?->format('Y-m-d') }}" class="p-2 border rounded">

  <button class="bg-pink-500 text-white rounded px-4">Terapkan</button>

  <a href="{{ route('admin.laporan.export', request()->query()) }}" 
     class="bg-green-500 text-white rounded px-4 text-center py-2">
     📄 Export CSV
  </a>

  <div class="text-right md:col-span-1 md:justify-self-end self-center font-semibold text-pink-700">
    Total: Rp {{ number_format($total,0,',','.') }}
  </div>

</form>

<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">
  <table class="w-full">
    <thead class="bg-pink-200">
      <tr>
        <th class="text-left py-2 px-3">Tanggal</th>
        <th class="text-left py-2 px-3">Pelanggan</th>
        <th class="text-left py-2 px-3">Metode Pembayaran</th>
        <th class="text-right py-2 px-3">Total (Rp)</th>
      </tr>
    </thead>

    <tbody>
      @foreach($data as $t)
      <tr class="border-b hover:bg-pink-50">

        {{-- tanggal appointment --}}
        <td class="py-2 px-3">
          {{ \Carbon\Carbon::parse($t->appointment_date)->format('Y-m-d') }}
        </td>

        {{-- pelanggan dari relasi user --}}
        <td class="py-2 px-3">
          {{ $t->user->name ?? '-' }}
        </td>

        {{-- metode pembayaran --}}
        <td class="py-2 px-3 uppercase">
          {{ $t->payment_method ?? '-' }}
        </td>

        {{-- total bayar --}}
        <td class="py-2 px-3 text-right">
          Rp {{ number_format($t->service->harga ?? 0,0,',','.') }}
        </td>

      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection
