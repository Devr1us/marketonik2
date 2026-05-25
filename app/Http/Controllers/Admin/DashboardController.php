<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Sales chart — last 7 days
        $salesChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo)->toDateString();
            $total = Order::whereDate('created_at', $date)->sum('total');
            $count = Order::whereDate('created_at', $date)->count();
            return [
                'date'  => now()->subDays($daysAgo)->format('d M'),
                'total' => (float) $total,
                'count' => (int) $count,
            ];
        });

        // Low stock products
        $lowStock = Product::query()
            ->where('is_active', true)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Category breakdown
        $categoryStats = Product::query()
            ->where('is_active', true)
            ->selectRaw('category, count(*) as total, sum(stock) as total_stock')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                'users'    => User::where('role', User::ROLE_PEMBELI)->count(),
                'products' => Product::where('is_active', true)->count(),
                'orders'   => Order::count(),
                'revenue'  => (float) Order::where('payment_status', 'lunas')->sum('total'),
                'pending'  => Order::where('payment_status', 'menunggu')->orWhere('payment_status', 'pending')->count(),
                'today'    => Order::whereDate('created_at', today())->count(),
            ],
            'recentOrders'  => Order::with('user:id,name,username')->withCount('items')->latest()->take(8)->get(),
            'salesChart'    => $salesChart,
            'lowStock'      => $lowStock,
            'categoryStats' => $categoryStats,
        ]);
    }

    public function report(Request $request): View
    {
        $from = $request->date('from') ?: now()->subDays(30)->startOfDay();
        $to = $request->date('to') ?: now()->endOfDay();

        $orders = Order::query()
            ->with('user:id,name,username')
            ->withCount('items')
            ->whereBetween('created_at', [$from, $to->copy()->endOfDay()])
            ->latest()
            ->get();

        $dailySales = Order::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total) as revenue')
            ->whereBetween('created_at', [$from, $to->copy()->endOfDay()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('product_title, SUM(quantity) as sold, SUM(line_total) as revenue')
            ->whereBetween('orders.created_at', [$from, $to->copy()->endOfDay()])
            ->groupBy('product_title')
            ->orderByDesc('sold')
            ->take(8)
            ->get();

        return view('admin.reports.index', [
            'from' => $from,
            'to' => $to,
            'orders' => $orders,
            'dailySales' => $dailySales,
            'topProducts' => $topProducts,
            'summary' => [
                'orders' => $orders->count(),
                'paid' => $orders->where('payment_status', 'lunas')->count(),
                'revenue' => (float) $orders->where('payment_status', 'lunas')->sum('total'),
                'gross' => (float) $orders->sum('total'),
            ],
        ]);
    }
}
