@extends('layouts.admin')
@section('title','Buat Transaksi')
@section('page','Buat Transaksi')

@section('content')
<div class="bg-white p-6 shadow rounded border-l-4 border-pink-400">

    <h2 class="text-xl font-bold mb-4">Buat Transaksi Dari Appointment</h2>

    <p><b>Pelanggan:</b> {{ $customer->name }}</p>
    <p><b>Layanan:</b> {{ $service->name }}</p>
    <p><b>Harga:</b> Rp {{ number_format($service->harga,0,',','.') }}</p>
    <p><b>Tanggal:</b> {{ $appointment->date }}</p>
    <p><b>Jam:</b> {{ $appointment->time }}</p>

    <hr class="my-4">

    <form action="{{ route('admin.transaksi.store') }}" method="POST">
        @csrf

        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

        <label>Status Pembayaran</label>
        <select name="status" class="w-full p-2 border rounded mb-3">
            <option value="paid">PAID</option>
            <option value="pending">PENDING</option>
        </select>

        <label>Metode Pembayaran</label>
        <select name="metode" class="w-full p-2 border rounded mb-3">
            <option value="cash">Cash</option>
            <option value="qris">QRIS</option>
            <option value="transfer">Transfer</option>
        </select>

        <button class="bg-pink-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>

</div>
@endsection
