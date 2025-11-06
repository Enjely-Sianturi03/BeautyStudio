@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Dashboard Owner Salon</h2>

    <div class="row my-3">
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Total Pelanggan</h5>
                <h2>{{ $totalCustomers ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Total Layanan</h5>
                <h2>{{ $totalServices ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Total Pendapatan</h5>
                <h2>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <h4 class="mt-4">Riwayat Transaksi</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions ?? [] as $t)
            <tr>
                <td>{{ $t->date ?? '-' }}</td>
                <td>{{ $t->customer->name ?? '-' }}</td>
                <td>{{ $t->service->name ?? '-' }}</td>
                <td>Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
