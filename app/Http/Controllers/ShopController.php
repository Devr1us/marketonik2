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

        // Search
        if ($search = trim((string) $request->get('q'))) {
            $q->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('seller_location', 'like', '%'.$search.'%');
            });
        }

        // Category filter
        if ($kategori = trim((string) $request->get('kategori'))) {
            $q->where('category', $kategori);
        }

        // Price filter
        if ($minPrice = (int) $request->get('min_harga')) {
            $q->whereRaw('(price * (1 - discount_percent / 100)) >= ?', [$minPrice]);
        }
        if ($maxPrice = (int) $request->get('max_harga')) {
            $q->whereRaw('(price * (1 - discount_percent / 100)) <= ?', [$maxPrice]);
        }

        // Sort
        $sort = $request->get('urut', 'terbaru');
        match ($sort) {
            'harga_asc'  => $q->orderByRaw('price * (1 - discount_percent / 100) ASC'),
            'harga_desc' => $q->orderByRaw('price * (1 - discount_percent / 100) DESC'),
            'diskon'     => $q->orderByDesc('discount_percent'),
            default      => $q->latest(),
        };

        $products = $q->paginate(12)->withQueryString();

        // Category counts for sidebar
        $categoryCounts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        return view('toko.index', compact('products', 'kategoryCounts', 'sort', 'kategori'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        $product->load('seller');

        // Related products (same category, different product)
        $related = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->with('seller')
            ->take(4)
            ->get();

        // Seller's other products
        $sellerProducts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('user_id', $product->user_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('toko.show', compact('product', 'related', 'sellerProducts'));
    }
}
