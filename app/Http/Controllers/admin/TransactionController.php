<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'items.product'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function detail($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.transactions.detail', compact('transaction'));
    }

    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'approved';
        $transaction->save();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi disetujui!');
    }

    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi ditolak!');
    }

}
