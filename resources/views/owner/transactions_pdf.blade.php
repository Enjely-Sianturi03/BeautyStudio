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
                <td>{{ $t->date }}</td>
                <td>{{ $t->customer->name }}</td>
                <td>{{ $t->service->name }}</td>
                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
