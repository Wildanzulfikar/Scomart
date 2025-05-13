<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $carts = $user->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang kosong!');
        }

        return view('user.checkout', compact('carts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:manual,online',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // hanya jika manual
        ]);

        $user = auth()->user();
        $carts = $user->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($carts as $cart) {
                $total += $cart->product->price * $cart->jumlah;
            }

            // Simpan bukti pembayaran kalau metode manual
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            } else {
                $buktiPath = null;
            }


            // Buat transaksi
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_pembayaran' => $buktiPath,
            ]);

            // Buat item transaksi
            foreach ($carts as $cart) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $cart->product_id,
                    'jumlah' => $cart->jumlah,
                    'harga_satuan' => $cart->product->price,
                ]);
            }

            // Hapus keranjang
            Cart::where('user_id', $user->id)->delete();

            DB::commit();
            return redirect()->route('riwayat.index')->with('success', 'Pembelian berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal melakukan pembelian: ' . $e->getMessage());
        }
    }

}
