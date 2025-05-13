<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index() {
    $totalUsers = User::where('role', 'user')->count();
    $totalProducts = Product::count();
    $totalTransactions = Transaction::count();
    $todayRevenue = Transaction::whereDate('created_at', today())->sum('total');

    $monthlyRevenue = Transaction::selectRaw('MONTH(created_at) as month, SUM(total) as total')
        ->whereYear('created_at', now()->year)
        ->where('status', 'approved')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    $labels = [];
    $data = [];

    for ($i = 1; $i <= 12; $i++) {
        $labels[] = date("F", mktime(0, 0, 0, $i, 10)); // Nama bulan
        $data[] = $monthlyRevenue[$i] ?? 0;
    }

    return view('admin.dashboard', compact(
        'totalUsers', 'totalProducts', 'totalTransactions', 'todayRevenue',
        'labels', 'data'
    ));
    }
}
