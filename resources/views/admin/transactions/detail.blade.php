@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-xl font-semibold">Detail Transaksi</h2>

    <div class="card p-4 mt-3">
        <h5 class="my-2">Informasi Transaksi</h5>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Nama User:</strong> {{ $transaction->user->name }}</li>
            <li class="list-group-item"><strong>Total:</strong> Rp{{ number_format($transaction->total, 0, ',', '.') }}</li>
            <li class="list-group-item"><strong>Metode Pembayaran:</strong> {{ ucfirst($transaction->metode_pembayaran) }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($transaction->status) }}</li>
            @if ($transaction->bukti_pembayaran)
                <li class="list-group-item">
                    <strong>Bukti Pembayaran:</strong><br>
                    <img src="{{ asset('storage/' . $transaction->bukti_pembayaran) }}" alt="Bukti Pembayaran" width="300px" class="mt-2">
                </li>
            @endif
        </ul>

        <h5>Produk dalam Transaksi</h5>
        <ul class="list-group mb-3">
            @foreach ($transaction->items as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <div>{{ $item->product->name }} (x{{ $item->jumlah }})</div>
                    <span>Rp{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>

        <div class="d-flex gap-2">
            <!-- Approve Button -->
            <form id="approveForm" action="{{ route('admin.transactions.approve', $transaction->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="button" class="btn btn-success" onclick="confirmApprove()">Approve</button>
            </form>

            <!-- Reject Button -->
            <form id="rejectForm" action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="button" class="btn btn-danger" onclick="confirmReject()">Reject</button>
            </form>
        </div>

        <div class="mt-4">
            <form action="{{ route('admin.transactions.updateStatus', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Ubah Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $transaction->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>

    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmApprove() {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Transaksi akan disetujui!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Approve!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approveForm').submit();
        }
    })
}

function confirmReject() {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Transaksi akan ditolak!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('rejectForm').submit();
        }
    })
}
</script>

<!-- Notifikasi Berhasil -->
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    })
</script>
@endif

@endsection
