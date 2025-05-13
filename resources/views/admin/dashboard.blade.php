@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('header')
    <div class="">
        <h2 class="h5 mb-0 fw-semibold">Dashboard Admin</h2>
    </div>
@endsection

@section('content')
<div class="bg-white">
    <div class="alert alert-light text-dark">
        Halo Admin, <strong>{{ Auth::user()->name }}</strong>!
    </div>
    <div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Pengguna</h5>
                <p class="card-text fs-4">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Produk</h5>
                <p class="card-text fs-4">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <p class="card-text fs-4">{{ $totalTransactions }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Pendapatan Hari Ini</h5>
                <p class="card-text fs-4">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <h5 class="mt-5">Pendapatan per Bulan ({{ date('Y') }})</h5>
    <canvas id="monthlyRevenueChart" height="100"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');

    const monthlyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($data) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
