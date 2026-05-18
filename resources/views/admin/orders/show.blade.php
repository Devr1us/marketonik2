@extends('layouts.admin')

@section('title', $order->order_code)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-violet-300 hover:text-violet-200">← Kembali</a>
    <h1 class="font-display mt-2 text-2xl font-bold text-white">{{ $order->order_code }}</h1>
    <p class="text-sm text-zinc-500">{{ $order->user->name }} ({{ $order->user->username }})</p>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <section class="rounded-2xl border border-white/10 p-5">
        <h2 class="text-sm font-semibold text-zinc-400">Item pesanan</h2>
        <ul class="mt-4 space-y-3">
            @foreach($order->items as $item)
                <li class="flex justify-between text-sm">
                    <span>{{ $item->product_title }} × {{ $item->quantity }}</span>
                    <span class="text-amber-200">Rp{{ number_format($item->line_total, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
        <p class="mt-4 border-t border-white/10 pt-4 text-right font-display text-xl font-bold text-white">
            Total Rp{{ number_format($order->total, 0, ',', '.') }}
        </p>
    </section>

    <section class="rounded-2xl border border-white/10 p-5">
        <h2 class="text-sm font-semibold text-zinc-400">Update status</h2>
        <form method="post" action="{{ route('admin.orders.status', $order) }}" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')
            <select name="payment_status" class="w-full rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-sm">
                <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                <option value="paid" @selected($order->payment_status === 'paid')>Paid</option>
                <option value="cancelled" @selected($order->payment_status === 'cancelled')>Cancelled</option>
            </select>
            <button class="w-full rounded-lg bg-violet-600 py-2 text-sm font-bold text-white">Simpan</button>
        </form>
        <p class="mt-4 text-xs text-zinc-600">Metode: {{ $order->payment_method }}</p>
    </section>
</div>
@endsection
