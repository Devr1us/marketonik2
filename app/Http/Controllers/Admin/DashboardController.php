<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'users' => User::where('role', User::ROLE_PEMBELI)->count(),
                'products' => Product::count(),
                'orders' => Order::count(),
                'revenue' => (float) Order::sum('total'),
                'pending' => Order::where('payment_status', 'pending')->count(),
            ],
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
        ]);
    }
}
