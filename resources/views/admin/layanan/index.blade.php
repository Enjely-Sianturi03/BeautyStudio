@extends('layouts.admin')
@section('title','Data Layanan')
@section('page','Data Layanan')

@section('content')
<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">
  <form method="POST" action="{{ route('admin.layanan.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
    @csrf
    <input name="nama" class="p-2 border rounded" placeholder="Nama Layanan" required>
    <input name="durasi_menit" type="number" class="p-2 border rounded" placeholder="Durasi (menit)" required>
    <input name="harga" type="number" class="p-2 border rounded" placeholder="Harga (Rp)" required>
    <input name="deskripsi" class="p-2 border rounded md:col-span-1" placeholder="Deskripsi">
    <button class="bg-pink-500 text-white rounded px-4">+ Tambah</button>
  </form>
</div>

<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">
  <table class="w-full">
    <thead class="bg-pink-200">
      <tr>
        <th class="text-left py-2 px-3">Nama</th>
        <th class="text-left py-2 px-3">Durasi</th>
        <th class="text-left py-2 px-3">Harga</th>
        <th class="text-left py-2 px-3">Deskripsi</th>
        <th class="text-center py-2 px-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $l)
      <tr class="border-b hover:bg-pink-50">
        <td class="py-2 px-3">{{ $l->nama }}</td>
        <td class="py-2 px-3">{{ $l->durasi_menit }} mnt</td>
        <td class="py-2 px-3">Rp {{ number_format($l->harga,0,',','.') }}</td>
        <td class="py-2 px-3">{{ $l->deskripsi }}</td>
        <td class="py-2 px-3 text-center">
          <form method="POST" action="{{ route('admin.layanan.destroy',$l) }}" onsubmit="return confirm('Hapus layanan?')" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-600 hover:underline">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection
