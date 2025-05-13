<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ProductViewController extends Controller
{
    public function index(Request $request)
    {
        // $products = Product::latest()->get();
        // return view('user.katalog', compact('products'));

        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        return view('user.katalog', compact('products'));
    }
}
