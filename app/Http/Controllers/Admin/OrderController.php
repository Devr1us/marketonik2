<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $shipping = $request->string('shipping')->toString();
        $q = $request->string('q')->trim();

        $orders = Order::query()
            ->with('user:id,name,username')
            ->withCount('items')
            ->when($status !== '', fn ($q) => $q->where('payment_status', $status))
            ->when($shipping !== '', fn ($query) => $query->where('shipping_status', $shipping))
            ->when($q->isNotEmpty(), function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('order_code', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($userQuery) => $userQuery
                            ->where('name', 'like', "%{$q}%")
                            ->orWhere('username', 'like', "%{$q}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status', 'shipping', 'q'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'payment_status' => ['required', 'in:pending,menunggu,lunas,cancelled'],
        ]);

        $order->update(['payment_status' => $data['payment_status']]);

        return back()->with('ok', 'Status pembayaran diperbarui.');
    }

    public function updateShipping(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'shipping_status'  => ['required', 'in:menunggu,diproses,dikirim,selesai,dibatalkan'],
            'tracking_number'  => ['nullable', 'string', 'max:100'],
            'shipping_address' => ['nullable', 'string', 'max:500'],
        ]);

        $order->update($data);

        return back()->with('ok', 'Status pengiriman diperbarui.');
    }
}
