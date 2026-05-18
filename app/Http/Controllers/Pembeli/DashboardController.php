<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('pembeli.dashboard', [
            'cartCount' => $user->cartItems()->count(),
            'orderCount' => $user->orders()->count(),
            'recentOrders' => $user->orders()->latest()->take(3)->get(),
            'cartTotal' => $user->cartItems()
                ->with('product')
                ->get()
                ->sum(fn ($item) => $item->product->effectivePrice() * $item->quantity),
        ]);
    }
}
