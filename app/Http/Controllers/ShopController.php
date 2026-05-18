<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $q = Product::query()->with('seller')->where('is_active', true)->where('stock', '>', 0);

        if ($search = trim((string) $request->get('q'))) {
            $q->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('seller_location', 'like', '%'.$search.'%');
            });
        }

        $products = $q->orderByDesc('discount_percent')->latest()->paginate(12)->withQueryString();

        return view('toko.index', compact('products'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        $product->load('seller');

        return view('toko.show', compact('product'));
    }
}
