@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-xl font-semibold">Riwayat Transaksi</h2>

    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    <div class="card p-4 mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($transaction->metode_pembayaran) }}</td>
                        <td>
                            @if ($transaction->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                            @elseif ($transaction->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($transaction->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaction->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $transaction->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">Lihat Bukti</a>
                            @else
                                Tidak Ada
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('riwayat.show', $transaction->id) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
