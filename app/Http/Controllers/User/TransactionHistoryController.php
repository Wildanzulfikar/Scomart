<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return view('user.riwayat.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('items.product')
                        ->where('user_id', Auth::id())
                        ->findOrFail($id);
        return view('user.riwayat.show', compact('transaction'));
    }

    public function download($id)
    {
        $transaction = Transaction::with('items.product')
                        ->where('user_id', auth()->id())
                        ->findOrFail($id);

        $pdf = Pdf::loadView('user.riwayat.pdf', compact('transaction'));

        return $pdf->download('struk-transaksi-'.$transaction->id.'.pdf');
    }

}
