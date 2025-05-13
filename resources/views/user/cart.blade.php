@extends('layouts.app')

@section('content')
<h3 class="my-3 font-semibold text-xl">Keranjang Belanja</h3>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($carts as $cart)
            @php
                $subtotal = $cart->jumlah * $cart->product->price;
                $total += $subtotal;
            @endphp
            <tr>
                <td>{{ $cart->product->name }}</td>
                <td>
                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="d-flex">
                        @csrf
                        @method('PUT')
                        <input type="number" name="jumlah" value="{{ $cart->jumlah }}" min="1" class="form-control me-2 rounded-md" style="width: 50px;">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
                <td>Rp{{ number_format($cart->product->price, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<h4 class="mb-4">Total: Rp{{ number_format($total, 0, ',', '.') }}</h4>

<form class="mb-4" action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <a class="bg-primary p-2 rounded-md text-white hover:bg-blue-500" href="{{ route('checkout.form') }}">Checkout Sekarang</a>
</form>
<a rel="stylesheet" class="bg-info p-2 rounded-md text-white hover:bg-blue-500" href="/katalog">Katalog</a>
@endsection
