@extends('layouts.app')

@section('content')
<div class="my-3">
    <h2 class="text-xl font-semibold">Katalog Produk Koperasi</h2>
</div>

<form action="{{ route('katalog.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control rounded-md" placeholder="Cari produk..." value="{{ request()->search }}">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Keranjang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $produk)
            <tr>
                <td>{{ $produk->name }}</td>
                <td>Rp{{ number_format($produk->price, 0, ',', '.') }}</td>
                <td>{{ $produk->description }}</td>
                <td><form action="{{ route('cart.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $produk->id }}">
                        <input type="number" name="jumlah" value="1" class="form-control rounded-lg mb-1 text-center" min="1" style="width: 50px; display: inline-block;">
                        <button class="btn py-2 ml-4 btn-success btn-sm">Tambah ke Keranjang</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </tbody>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
        @endif
</table>
@endsection
