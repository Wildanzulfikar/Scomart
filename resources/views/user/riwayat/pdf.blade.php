<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Struk Transaksi #{{ $transaction->id }}</h2>
    <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->name}}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

