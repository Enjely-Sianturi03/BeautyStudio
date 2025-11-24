@extends('layouts.admin')
@section('title','Data Pelanggan')
@section('page','Data Pelanggan')

@section('content')
<div class="bg-white shadow rounded p-6 mb-6 border-l-4 border-pink-400">
  <form method="POST" action="{{ route('admin.pelanggan.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
    @csrf
    <input name="name" class="p-2 border rounded" placeholder="Nama" required>
    <input name="telepon" class="p-2 border rounded" placeholder="Telepon">
    <input name="email" class="p-2 border rounded" placeholder="Email">
    <input type="password" name="password" class="p-2 border rounded" placeholder="Password" required>
    
    <button class="bg-pink-500 text-white rounded px-4">+ Tambah</button>
  </form>
</div>

<div class="bg-white shadow rounded p-6 border-l-4 border-pink-400">
  <table class="w-full">
    <thead class="bg-pink-200">
      <tr>
        <th class="text-left py-2 px-3">Nama</th>
        <th class="text-left py-2 px-3">Telepon</th>
        <th class="text-left py-2 px-3">Email</th>
        <th class="text-center py-2 px-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $p)
      <tr class="border-b hover:bg-pink-50">
        <td class="py-2 px-3">{{ $p->name }}</td>
        <td class="py-2 px-3">{{ $p->telepon }}</td>
        <td class="py-2 px-3">{{ $p->email }}</td>
        
        <td class="py-2 px-3 text-center">
          <form method="POST" action="{{ route('admin.pelanggan.update',$p) }}" class="inline">
            @csrf @method('PUT')
            <input type="hidden" name="nama" value="{{ $p->name }}">
            <button class="text-blue-600 hover:underline">Quick Save</button>
          </form>

          <form method="POST" action="{{ route('admin.pelanggan.destroy',$p) }}" class="inline" onsubmit="return confirm('Hapus?')">
            @csrf @method('DELETE')
            <button class="text-red-600 hover:underline ml-2">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection
