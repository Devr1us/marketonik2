<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProduct = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('discount_percent', '>', 0)
            ->orderByDesc('discount_percent')
            ->first();

        $promoProducts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('discount_percent', '>', 0)
            ->orderByDesc('discount_percent')
            ->take(4)
            ->get();

        $latestProducts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('seller')
            ->latest()
            ->take(6)
            ->get();

        $categoryCounts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $stats = [
            'products' => Product::where('is_active', true)->count(),
            'sellers'  => User::whereHas('products')->count(),
            'orders'   => Order::count(),
        ];

        return view('home', compact(
            'featuredProduct',
            'promoProducts',
            'latestProducts',
            'categoryCounts',
            'stats'
        ));
    }
}
