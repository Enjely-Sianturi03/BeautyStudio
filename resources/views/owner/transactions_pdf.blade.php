<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e5a3c5; padding: 8px; }
        th { background: #fce7f3; }
        h2 { color: #be185d; }
    </style>
</head>
<body>
    <h2>Riwayat Transaksi Salon</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
            <tr>
                                <td class="px-6 py-3">{{ $t->appointment_date ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->user->name ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $t->service->nama ?? '-' }}</td>
                                <td class="px-6 py-3 font-semibold text-pink-700">Rp {{ number_format($t->service->harga ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
