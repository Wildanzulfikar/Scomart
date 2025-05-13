@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="font-semibold text-xl">Manajemen Transaksi</h2>

    <div class="card p-4 mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama User</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($transaction->metode_pembayaran) }}</td>
                        <td>
                            @if ($transaction->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($transaction->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($transaction->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaction->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $transaction->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Bukti</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.transactions.detail', $transaction->id) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
