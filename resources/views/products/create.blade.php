@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="my-4 font-semibold text-xl">Tambah Produk</h2>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control rounded-md" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control rounded-md" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <input type="text" name="description" class="form-control rounded-md" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
