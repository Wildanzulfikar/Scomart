<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\ProductViewController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\TransactionHistoryController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\TransactionAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login'); // kalau belum login
    }

    if (Auth::user()->role == 'admin') {
        return redirect()->route('dashboard'); // ke dashboard admin
    } else {
        return redirect()->route('katalog.index'); // ke halaman user biasa
    }
});

Route::middleware(['auth', 'user'])->get('/katalog', [ProductViewController::class, 'index'])->name('katalog.index');
Route::resource('products', ProductController::class)->middleware('admin');

Route::get('/checkout', [CheckoutController::class, 'index'])->middleware(['auth', 'user'])->name('checkout.form');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware(['auth', 'user'])->name('checkout.store');

Route::middleware(['auth', 'user'])->group(function () {
    // Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/katalog', [ProductViewController::class, 'index'])->name('katalog.index');
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/keranjang/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/riwayat-transaksi', [TransactionHistoryController::class, 'index'])->name('riwayat.transaksi');
    Route::get('/riwayat-transaksi/{id}', [TransactionHistoryController::class, 'show'])->name('riwayat.detail');
    Route::get('/riwayat-transaksi/{id}/download', [TransactionHistoryController::class, 'download'])->name('riwayat.download');

});

Route::prefix('riwayat')->middleware('auth')->group(function () {
    Route::get('/', [TransactionHistoryController::class, 'index'])->name('riwayat.index');
    Route::get('/{id}', [TransactionHistoryController::class, 'show'])->name('riwayat.show');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [AdminTransactionController::class, 'detail'])->name('transactions.detail');
    Route::post('/transactions/{id}/approve', [AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');
    Route::put('/transactions/{id}/status', [TransactionAdminController::class, 'updateStatus'])->name('transactions.updateStatus');
});

Route::middleware(['auth', 'user'])->get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

Route::middleware(['auth'])->get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('user.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
