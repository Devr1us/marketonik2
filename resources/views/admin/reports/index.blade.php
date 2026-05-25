@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Analitik</p>
        <h1 class="font-display text-2xl font-bold text-white">Laporan Penjualan</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ $from->format('d M Y') }} sampai {{ $to->format('d M Y') }}</p>
    </div>
    <form method="get" class="flex flex-wrap gap-2">
        <input type="date" name="from" value="{{ $from->toDateString() }}" class="rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300">
        <input type="date" name="to" value="{{ $to->toDateString() }}" class="rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300">
        <button class="rounded-xl bg-violet-600 px-4 py-2 text-xs font-bold text-white hover:bg-violet-500">Terapkan</button>
    </form>
</div>

<div class="mt-6 grid gap-4 md:grid-cols-4">
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Total Pesanan</p>
        <p class="mt-2 text-2xl font-bold text-white">{{ $summary['orders'] }}</p>
    </div>
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Pesanan Lunas</p>
        <p class="mt-2 text-2xl font-bold text-emerald-300">{{ $summary['paid'] }}</p>
    </div>
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Omzet Lunas</p>
        <p class="mt-2 text-2xl font-bold text-white">Rp{{ number_format($summary['revenue'], 0, ',', '.') }}</p>
    </div>
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Nilai Transaksi</p>
        <p class="mt-2 text-2xl font-bold text-amber-200">Rp{{ number_format($summary['gross'], 0, ',', '.') }}</p>
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <h2 class="font-display text-lg font-bold text-white">Penjualan Harian</h2>
        <div class="mt-4 space-y-3">
            @forelse($dailySales as $day)
                <div class="flex items-center justify-between rounded-xl border border-white/10 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-white">{{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}</p>
                        <p class="text-[10px] text-zinc-500">{{ $day->total_orders }} pesanan</p>
                    </div>
                    <p class="text-sm font-bold text-amber-200">Rp{{ number_format($day->revenue, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="text-sm text-zinc-500">Belum ada transaksi pada rentang ini.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <h2 class="font-display text-lg font-bold text-white">Produk Terlaris</h2>
        <div class="mt-4 space-y-3">
            @forelse($topProducts as $product)
                <div class="flex items-center justify-between rounded-xl border border-white/10 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $product->product_title }}</p>
                        <p class="text-[10px] text-zinc-500">{{ $product->sold }} unit terjual</p>
                    </div>
                    <p class="text-sm font-bold text-amber-200">Rp{{ number_format($product->revenue, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="text-sm text-zinc-500">Belum ada produk terjual.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="mt-6 overflow-hidden rounded-2xl border border-white/10">
    <table class="w-full text-left text-sm">
        <thead class="bg-white/[0.03] text-xs uppercase text-zinc-500">
            <tr>
                <th class="px-5 py-3">Kode</th>
                <th class="px-5 py-3">Pembeli</th>
                <th class="px-5 py-3">Item</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3 text-right">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($orders as $order)
                <tr>
                    <td class="px-5 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs text-amber-200">{{ $order->order_code }}</a></td>
                    <td class="px-5 py-3 text-xs text-zinc-300">{{ $order->user?->name }}</td>
                    <td class="px-5 py-3 text-xs text-zinc-400">{{ $order->items_count }}</td>
                    <td class="px-5 py-3"><span class="rounded-full border {{ $order->paymentStatusColor() }} px-2 py-0.5 text-[10px] capitalize">{{ $order->payment_status }}</span></td>
                    <td class="px-5 py-3 text-right text-xs font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-zinc-500">Tidak ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
