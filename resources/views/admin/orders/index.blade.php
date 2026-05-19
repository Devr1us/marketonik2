@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Manajemen</p>
        <h1 class="font-display text-2xl font-bold text-white">Daftar Pesanan</h1>
        <p class="text-sm text-zinc-500 mt-1">{{ $orders->total() }} pesanan ditemukan</p>
    </div>
    <form method="get" class="flex flex-wrap gap-2">
        <select name="status" class="rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300">
            <option value="">Semua status</option>
            <option value="pending" @selected($status === 'pending')>Pending</option>
            <option value="menunggu" @selected($status === 'menunggu')>Menunggu</option>
            <option value="lunas" @selected($status === 'lunas')>Lunas</option>
            <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
        </select>
        <button class="rounded-xl bg-violet-600 px-4 py-2 text-xs font-bold text-white hover:bg-violet-500 transition">Filter</button>
    </form>
</div>

<div class="mt-6 overflow-hidden rounded-2xl border border-white/10">
    <table class="w-full text-left text-sm">
        <thead class="bg-white/[0.03] text-xs uppercase text-zinc-500">
            <tr>
                <th class="px-5 py-3">Kode Pesanan</th>
                <th class="px-5 py-3 hidden sm:table-cell">Pembeli</th>
                <th class="px-5 py-3">Total</th>
                <th class="px-5 py-3">Pembayaran</th>
                <th class="px-5 py-3 hidden lg:table-cell">Pengiriman</th>
                <th class="px-5 py-3 hidden md:table-cell">Tanggal</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($orders as $order)
            <tr class="hover:bg-white/[0.02] transition">
                <td class="px-5 py-4">
                    <p class="font-mono text-xs font-semibold text-amber-200">{{ $order->order_code }}</p>
                    <p class="text-[10px] text-zinc-600 mt-0.5">{{ $order->items_count }} item</p>
                </td>
                <td class="px-5 py-4 hidden sm:table-cell">
                    <p class="text-xs text-zinc-300">{{ $order->user->name }}</p>
                    <p class="text-[10px] text-zinc-600">@{{ $order->user->username }}</p>
                </td>
                <td class="px-5 py-4 text-xs font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                <td class="px-5 py-4">
                    <span class="rounded-full border {{ $order->paymentStatusColor() }} px-2 py-0.5 text-[10px] font-semibold capitalize">
                        {{ $order->payment_status }}
                    </span>
                </td>
                <td class="px-5 py-4 hidden lg:table-cell">
                    <span class="rounded-full border {{ $order->shippingStatusColor() }} px-2 py-0.5 text-[10px] font-semibold">
                        {{ $order->shippingStatusLabel() }}
                    </span>
                </td>
                <td class="px-5 py-4 hidden md:table-cell text-[10px] text-zinc-500">
                    {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y') }}<br>
                    {{ $order->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                </td>
                <td class="px-5 py-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="rounded-lg border border-white/15 px-3 py-1.5 text-xs font-semibold text-zinc-300 hover:border-violet-500/40 hover:text-violet-200 transition">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-16 text-center">
                    <p class="text-4xl mb-3">📭</p>
                    <p class="text-zinc-500">Belum ada pesanan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
