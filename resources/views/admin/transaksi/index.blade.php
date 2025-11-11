@extends('layouts.admin')
@section('title','Transaksi')
@section('page','Transaksi')

@section('content')
<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">
  <form method="POST" action="{{ route('admin.transaksi.store') }}" class="space-y-3">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
      <select name="pelanggan_id" class="p-2 border rounded" required>
        <option value="">--Pelanggan--</option>
        @foreach($pelanggans as $p) <option value="{{ $p->id }}">{{ $p->nama }}</option>@endforeach
      </select>
      <select name="jadwal_id" class="p-2 border rounded">
        <option value="">(Opsional) Tautkan Jadwal</option>
        @foreach($jadwals as $j) <option value="{{ $j->id }}">{{ $j->mulai_at->format('d/m H:i') }} - {{ $j->pelanggan->nama }}</option>@endforeach
      </select>
      <select name="metode" class="p-2 border rounded">
        <option value="cash">Cash</option>
        <option value="qris">QRIS</option>
        <option value="transfer">Transfer</option>
      </select>
      <button class="bg-pink-500 text-white rounded px-4">Simpan Transaksi</button>
    </div>

    <div id="items" class="grid grid-cols-1 md:grid-cols-3 gap-3">
      <div class="p-3 border rounded">
        <label class="block text-sm mb-1">Layanan</label>
        <select name="items[0][layanan_id]" class="p-2 border rounded w-full">
          @foreach($layanans as $l) <option value="{{ $l->id }}">{{ $l->nama }} - Rp {{ number_format($l->harga,0,',','.') }}</option>@endforeach
        </select>
        <label class="block text-sm mt-2 mb-1">Qty</label>
        <input type="number" name="items[0][qty]" value="1" class="p-2 border rounded w-full">
      </div>
      <!-- Tambahkan blok serupa secara manual atau pakai JS dinamis sesuai kebutuhan -->
    </div>
  </form>
</div>

<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">
  <table class="w-full">
    <thead class="bg-pink-200">
      <tr>
        <th class="text-left py-2 px-3">Tanggal</th>
        <th class="text-left py-2 px-3">Pelanggan</th>
        <th class="text-left py-2 px-3">Metode</th>
        <th class="text-right py-2 px-3">Total (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $t)
      <tr class="border-b hover:bg-pink-50">
        <td class="py-2 px-3">{{ $t->created_at->format('Y-m-d H:i') }}</td>
        <td class="py-2 px-3">{{ $t->pelanggan->nama ?? '-' }}</td>
        <td class="py-2 px-3 uppercase">{{ $t->metode }}</td>
        <td class="py-2 px-3 text-right">Rp {{ number_format($t->total,0,',','.') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection
