@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Panel Kontrol</p>
        <h1 class="font-display mt-1 text-3xl font-extrabold text-white">Dashboard Admin</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ now()->timezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
    @foreach([
        ['label' => 'Total Pembeli', 'value' => number_format($stats['users']), 'icon' => '👥', 'color' => 'from-sky-500/15', 'text' => 'text-sky-300', 'sub' => 'pengguna terdaftar'],
        ['label' => 'Produk Aktif', 'value' => number_format($stats['products']), 'icon' => '📦', 'color' => 'from-amber-500/15', 'text' => 'text-amber-300', 'sub' => 'produk tersedia'],
        ['label' => 'Total Pesanan', 'value' => number_format($stats['orders']), 'icon' => '🧾', 'color' => 'from-emerald-500/15', 'text' => 'text-emerald-300', 'sub' => 'semua waktu'],
        ['label' => 'Pesanan Hari Ini', 'value' => number_format($stats['today']), 'icon' => '📅', 'color' => 'from-cyan-500/15', 'text' => 'text-cyan-300', 'sub' => 'masuk hari ini'],
        ['label' => 'Menunggu', 'value' => number_format($stats['pending']), 'icon' => '⏳', 'color' => 'from-rose-500/15', 'text' => 'text-rose-300', 'sub' => 'perlu konfirmasi'],
        ['label' => 'Omzet Lunas', 'value' => 'Rp'.number_format($stats['revenue'], 0, ',', '.'), 'icon' => '💰', 'color' => 'from-violet-500/15', 'text' => 'text-violet-300', 'sub' => 'total pendapatan'],
    ] as $card)
    <div class="rounded-2xl border border-white/10 bg-gradient-to-br {{ $card['color'] }} to-transparent p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $card['label'] }}</p>
            <span class="text-2xl">{{ $card['icon'] }}</span>
        </div>
        <p class="font-display mt-3 text-2xl font-bold {{ $card['text'] }}">{{ $card['value'] }}</p>
        <p class="mt-1 text-xs text-zinc-600">{{ $card['sub'] }}</p>
    </div>
    @endforeach
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-3">

    {{-- Sales Chart --}}
    <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-white/[0.02] p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-lg font-bold text-white">Penjualan 7 Hari Terakhir</h2>
            <span class="text-xs text-zinc-500">Omzet harian</span>
        </div>
        @php
            $maxVal = $salesChart->max('total') ?: 1;
        @endphp
        <div class="flex items-end gap-2 h-40">
            @foreach($salesChart as $day)
            @php $height = $maxVal > 0 ? max(4, round(($day['total'] / $maxVal) * 100)) : 4; @endphp
            <div class="flex flex-1 flex-col items-center gap-1 group">
                <div class="relative w-full flex items-end justify-center" style="height: 120px;">
                    <div class="w-full rounded-t-lg bg-gradient-to-t from-violet-600 to-violet-400 transition-all hover:from-amber-500 hover:to-amber-300 cursor-default"
                        style="height: {{ $height }}%"
                        title="Rp{{ number_format($day['total'], 0, ',', '.') }} · {{ $day['count'] }} pesanan">
                    </div>
                    @if($day['count'] > 0)
                    <span class="absolute -top-5 left-1/2 -translate-x-1/2 text-[9px] font-bold text-violet-300 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        {{ $day['count'] }}x
                    </span>
                    @endif
                </div>
                <span class="text-[9px] text-zinc-600 whitespace-nowrap">{{ $day['date'] }}</span>
            </div>
            @endforeach
        </div>
        <div class="mt-4 flex items-center gap-4 text-xs text-zinc-500">
            <span>Total 7 hari: <span class="text-violet-300 font-semibold">Rp{{ number_format($salesChart->sum('total'), 0, ',', '.') }}</span></span>
            <span>·</span>
            <span>{{ $salesChart->sum('count') }} pesanan</span>
        </div>
    </div>

    {{-- Category Stats --}}
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-6">
        <h2 class="font-display text-lg font-bold text-white mb-4">Produk per Kategori</h2>
        @php $maxCat = $categoryStats->max('total') ?: 1; @endphp
        <div class="space-y-3">
            @forelse($categoryStats as $cat)
            <div>
                <div class="flex items-center justify-between text-xs mb-1">
                    <span class="text-zinc-400 truncate">{{ $cat->category }}</span>
                    <span class="text-zinc-500 shrink-0 ml-2">{{ $cat->total }}</span>
                </div>
                <div class="h-1.5 w-full rounded-full bg-white/5">
                    <div class="h-1.5 rounded-full bg-gradient-to-r from-violet-500 to-violet-400"
                        style="width: {{ round(($cat->total / $maxCat) * 100) }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-xs text-zinc-600">Belum ada data.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-3">

    {{-- Recent Orders --}}
    <div class="lg:col-span-2 rounded-2xl border border-white/10 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
            <h2 class="font-display text-base font-bold text-white">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-violet-400 hover:text-violet-300">Lihat semua →</a>
        </div>
        <table class="w-full text-left text-sm">
            <thead class="bg-white/[0.03] text-xs uppercase text-zinc-500">
                <tr>
                    <th class="px-5 py-3">Kode</th>
                    <th class="px-5 py-3 hidden sm:table-cell">Pembeli</th>
                    <th class="px-5 py-3">Total</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 hidden md:table-cell">Pengiriman</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-white/[0.02] transition">
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs text-amber-200 hover:text-amber-300">{{ $order->order_code }}</a>
                        <p class="text-[10px] text-zinc-600">{{ $order->created_at->diffForHumans() }}</p>
                    </td>
                    <td class="px-5 py-3 hidden sm:table-cell">
                        <p class="text-xs text-zinc-300">{{ $order->user->name }}</p>
                        <p class="text-[10px] text-zinc-600">{{ $order->items_count }} item</p>
                    </td>
                    <td class="px-5 py-3 text-xs font-semibold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-5 py-3">
                        <span class="rounded-full border {{ $order->paymentStatusColor() }} px-2 py-0.5 text-[10px] font-semibold capitalize">
                            {{ $order->payment_status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 hidden md:table-cell">
                        <span class="rounded-full border {{ $order->shippingStatusColor() }} px-2 py-0.5 text-[10px] font-semibold">
                            {{ $order->shippingStatusLabel() }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-zinc-500">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Low Stock --}}
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-base font-bold text-white">⚠️ Stok Menipis</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-violet-400 hover:text-violet-300">Kelola →</a>
        </div>
        @forelse($lowStock as $p)
        <div class="flex items-center gap-3 py-2.5 border-b border-white/5 last:border-0">
            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-lg bg-zinc-800">
                @if($p->displayImageUrl())
                    <img src="{{ $p->displayImageUrl() }}" alt="{{ $p->title }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-lg text-zinc-600">◇</div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-white truncate">{{ $p->title }}</p>
                <p class="text-[10px] text-zinc-500">{{ $p->category }}</p>
            </div>
            <span class="shrink-0 rounded-full {{ $p->stock <= 2 ? 'bg-rose-500/20 text-rose-300' : 'bg-yellow-500/20 text-yellow-300' }} px-2 py-0.5 text-[10px] font-bold">
                {{ $p->stock }} sisa
            </span>
        </div>
        @empty
        <div class="py-8 text-center">
            <p class="text-3xl mb-2">✅</p>
            <p class="text-xs text-zinc-500">Semua stok aman</p>
        </div>
        @endforelse
    </div>
</div>

@endsection
