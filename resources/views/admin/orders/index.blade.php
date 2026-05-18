@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="font-display text-2xl font-bold text-white">Pesanan</h1>
    </div>
    <form method="get" class="flex gap-2">
        <select name="status" class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-sm">
            <option value="">Semua status</option>
            <option value="pending" @selected($status === 'pending')>Pending</option>
            <option value="paid" @selected($status === 'paid')>Paid</option>
            <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
        </select>
        <button class="rounded-lg bg-violet-600 px-4 py-2 text-xs font-bold text-white">Filter</button>
    </form>
</div>

<div class="mt-8 space-y-3">
    @forelse($orders as $order)
        <a href="{{ route('admin.orders.show', $order) }}" class="block rounded-xl border border-white/10 bg-white/[0.02] p-4 hover:border-violet-500/30">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <p class="font-mono text-sm text-amber-200">{{ $order->order_code }}</p>
                <span class="rounded-full border border-white/15 px-2 py-0.5 text-xs capitalize">{{ $order->payment_status }}</span>
            </div>
            <p class="mt-2 text-sm text-zinc-400">{{ $order->user->name }} · {{ $order->items_count }} item</p>
            <p class="mt-1 font-display font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
        </a>
    @empty
        <p class="py-12 text-center text-zinc-500">Belum ada pesanan.</p>
    @endforelse
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
