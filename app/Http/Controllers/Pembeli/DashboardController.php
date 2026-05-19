<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $recentOrders = $user->orders()
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        $cartTotal = $user->cartItems()
            ->with('product')
            ->get()
            ->sum(fn ($item) => $item->product->effectivePrice() * $item->quantity);

        $promoProduct = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('discount_percent', '>', 0)
            ->orderByDesc('discount_percent')
            ->first();

        return view('pembeli.dashboard', [
            'cartCount'      => $user->cartItems()->count(),
            'orderCount'     => $user->orders()->count(),
            'myProductCount' => $user->products()->where('is_active', true)->count(),
            'recentOrders'   => $recentOrders,
            'cartTotal'      => $cartTotal,
            'promoProduct'   => $promoProduct,
        ]);
    }
}
