@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Checkout</h2>

    <div class="card p-4 mt-3">
        <h5>Rincian Pembelian</h5>
        <ul class="list-group mb-3">
            @php $total = 0; @endphp
            @foreach ($carts as $cart)
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        {{ $cart->product->name }} (x{{ $cart->jumlah }})
                    </div>
                    <span>Rp{{ number_format($cart->product->price * $cart->jumlah, 0, ',', '.') }}</span>
                </li>
                @php $total += $cart->product->price * $cart->jumlah; @endphp
            @endforeach
            <li class="list-group-item d-flex justify-content-between fw-bold">
                Total:
                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
            </li>
        </ul>

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" onchange="toggleBukti()" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="manual">Manual (Upload Bukti Transfer)</option>
                    <option value="online">Online</option>
                </select>
            </div>

            <div class="mb-3" id="bukti_container" style="display: none;">
                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>

                <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success">Checkout Sekarang</button>
        </form>
    </div>
</div>
<script>
    function toggleBukti() {
        const metode = document.getElementById('metode_pembayaran').value;
        console.log(metode);
        const container = document.getElementById('bukti_container');
        if (metode === 'manual') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>
@endsection
