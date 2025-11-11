@extends('layouts.admin')
@section('title','Jadwal Layanan')
@section('page','Jadwal Layanan')

@section('content')
<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">
  <form method="POST" action="{{ route('admin.jadwal.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
    @csrf
    <select name="pelanggan_id" class="p-2 border rounded" required>
      <option value="">--Pelanggan--</option>
      @foreach($pelanggans as $p) <option value="{{ $p->id }}">{{ $p->nama }}</option> @endforeach
    </select>
    <select name="layanan_id" class="p-2 border rounded" required>
      <option value="">--Layanan--</option>
      @foreach($layanans as $l) <option value="{{ $l->id }}">{{ $l->nama }}</option> @endforeach
    </select>
    <input name="staf" class="p-2 border rounded" placeholder="Staf">
    <input type="datetime-local" name="mulai_at" class="p-2 border rounded" required>
    <select name="status" class="p-2 border rounded">
      <option value="dijadwalkan">Dijadwalkan</option>
      <option value="selesai">Selesai</option>
      <option value="batal">Batal</option>
    </select>
    <button class="bg-pink-500 text-white rounded px-4">+ Jadwalkan</button>
  </form>
</div>

<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">
  <table class="w-full">
    <thead class="bg-pink-200">
      <tr>
        <th class="text-left py-2 px-3">Tanggal</th>
        <th class="text-left py-2 px-3">Pelanggan</th>
        <th class="text-left py-2 px-3">Layanan</th>
        <th class="text-left py-2 px-3">Staf</th>
        <th class="text-left py-2 px-3">Status</th>
        <th class="text-center py-2 px-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $j)
      <tr class="border-b hover:bg-pink-50">
        <td class="py-2 px-3">{{ $j->mulai_at->format('Y-m-d H:i') }}</td>
        <td class="py-2 px-3">{{ $j->pelanggan->nama }}</td>
        <td class="py-2 px-3">{{ $j->layanan->nama }}</td>
        <td class="py-2 px-3">{{ $j->staf }}</td>
        <td class="py-2 px-3">{{ ucfirst($j->status) }}</td>
        <td class="py-2 px-3 text-center">
          <form method="POST" action="{{ route('admin.jadwal.destroy',$j) }}" onsubmit="return confirm('Hapus jadwal?')" class="inline">
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
