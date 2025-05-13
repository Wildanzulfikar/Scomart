@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="">Detail Transaksi #{{ $transaction->id }}</h2>

    <div class="card p-4 mt-3">
        <h5 class="pb-4">Informasi Transaksi</h5>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Total:</strong> Rp{{ number_format($transaction->total, 0, ',', '.') }}</li>
            <li class="list-group-item"><strong>Metode Pembayaran:</strong> {{ ucfirst($transaction->metode_pembayaran) }}</li>
            <li class="list-group-item"><strong>Status:</strong>
                @if ($transaction->status == 'pending')
                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                @elseif ($transaction->status == 'approved')
                    <span class="badge bg-success">Disetujui</span>
                @elseif ($transaction->status == 'rejected')
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </li>
            @if ($transaction->bukti_pembayaran)
                <li class="list-group-item">
                    <strong>Bukti Pembayaran:</strong><br>
                    <img src="{{ asset('storage/' . $transaction->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid mt-2" style="max-width: 400px;">
                </li>
            @endif
        </ul>

        <h5 class="pb-4">Item Pembelian</h5>
        <table class="table table-bordered">
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
                        <td>{{ $item->product->name }}</td>
                        <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
                        <td><a href="{{ route('riwayat.download', $transaction->id) }}" class="btn btn-success mb-3">Download Struk PDF</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
