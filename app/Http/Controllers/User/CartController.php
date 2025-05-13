<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        return view('user.cart', compact('carts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id],
            ['jumlah' => \DB::raw($request->jumlah)]
        );

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id != auth()->id()) {
            return back()->with('error', 'Akses tidak diizinkan.');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart->jumlah = $request->jumlah;
        $cart->save();

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id == auth()->id()) {
            $cart->delete();
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
