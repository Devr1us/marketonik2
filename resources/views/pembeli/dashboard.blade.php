@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Welcome header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Selamat datang kembali</p>
        <h1 class="font-display mt-1 text-3xl font-extrabold text-white md:text-4xl">
            Halo, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-1 text-sm text-zinc-400">@{{ auth()->user()->username }} · Bergabung {{ auth()->user()->created_at->diffForHumans() }}</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('toko.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/15 px-4 py-2.5 text-sm font-semibold text-zinc-300 hover:border-amber-500/40 hover:text-amber-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Belanja
        </a>
        <a href="{{ route('jual.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-4 py-2.5 text-sm font-bold text-zinc-950 hover:brightness-110 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Jual Produk
        </a>
    </div>
</div>

{{-- Stats cards --}}
<div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-amber-500/10 to-transparent p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Keranjang</p>
            <span class="text-2xl">🛒</span>
        </div>
        <p class="font-display mt-3 text-3xl font-bold text-amber-200">{{ $cartCount }}</p>
        <p class="mt-1 text-xs text-zinc-500">item menunggu checkout</p>
        <a href="{{ route('keranjang.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-amber-400 hover:text-amber-300">
            Lihat keranjang <span>→</span>
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-emerald-500/10 to-transparent p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Total Pesanan</p>
            <span class="text-2xl">📦</span>
        </div>
        <p class="font-display mt-3 text-3xl font-bold text-emerald-200">{{ $orderCount }}</p>
        <p class="mt-1 text-xs text-zinc-500">pesanan dibuat</p>
        <a href="{{ route('pesanan.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-emerald-400 hover:text-emerald-300">
            Riwayat pesanan <span>→</span>
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-violet-500/10 to-transparent p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Produk Dijual</p>
            <span class="text-2xl">🏪</span>
        </div>
        <p class="font-display mt-3 text-3xl font-bold text-violet-200">{{ $myProductCount }}</p>
        <p class="mt-1 text-xs text-zinc-500">produk aktif</p>
        <a href="{{ route('jual.create') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-violet-400 hover:text-violet-300">
            Tambah produk <span>→</span>
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-sky-500/10 to-transparent p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Estimasi Keranjang</p>
            <span class="text-2xl">💰</span>
        </div>
        <p class="font-display mt-3 text-xl font-bold text-sky-200">Rp{{ number_format($cartTotal, 0, ',', '.') }}</p>
        <p class="mt-1 text-xs text-zinc-500">total nilai keranjang</p>
        <a href="{{ route('checkout.create') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-sky-400 hover:text-sky-300">
            Checkout <span>→</span>
        </a>
    </div>
</div>

<div class="mt-10 grid gap-8 lg:grid-cols-3">

    {{-- Recent Orders --}}
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold text-white">Pesanan Terakhir</h2>
            <a href="{{ route('pesanan.index') }}" class="text-xs text-amber-400 hover:text-amber-300">Lihat semua →</a>
        </div>

        @if($recentOrders->isNotEmpty())
        <div class="space-y-3">
            @foreach($recentOrders as $order)
            <a href="{{ route('pesanan.show', $order) }}" class="block rounded-2xl border border-white/10 bg-white/[0.02] p-4 hover:border-amber-500/30 transition">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-mono text-sm font-semibold text-amber-200">{{ $order->order_code }}</p>
                        <p class="mt-0.5 text-xs text-zinc-500">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y · H:i') }} WIB</p>
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            <span class="rounded-full border {{ $order->paymentStatusColor() }} px-2 py-0.5 text-[10px] font-semibold capitalize">
                                {{ $order->payment_status }}
                            </span>
                            <span class="rounded-full border {{ $order->shippingStatusColor() }} px-2 py-0.5 text-[10px] font-semibold">
                                {{ $order->shippingStatusLabel() }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-display font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        <p class="text-xs text-zinc-600 mt-0.5">{{ $order->items_count }} item</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="rounded-2xl border border-dashed border-white/10 bg-white/[0.01] py-12 text-center">
            <p class="text-4xl mb-3">📭</p>
            <p class="text-sm text-zinc-500">Belum ada pesanan</p>
            <a href="{{ route('toko.index') }}" class="mt-3 inline-block text-sm font-semibold text-amber-400 hover:text-amber-300">Mulai belanja →</a>
        </div>
        @endif
    </div>

    {{-- Quick actions + promo --}}
    <div class="space-y-4">
        <h2 class="font-display text-lg font-bold text-white">Aksi Cepat</h2>

        <a href="{{ route('toko.index') }}" class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 hover:border-amber-500/30 transition group">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-xl shrink-0">🛍️</span>
            <div>
                <p class="text-sm font-semibold text-white group-hover:text-amber-200">Jelajahi Katalog</p>
                <p class="text-xs text-zinc-500">Temukan produk terbaru</p>
            </div>
        </a>

        <a href="{{ route('keranjang.index') }}" class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 hover:border-amber-500/30 transition group">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-xl shrink-0">🛒</span>
            <div>
                <p class="text-sm font-semibold text-white group-hover:text-amber-200">Keranjang Saya</p>
                <p class="text-xs text-zinc-500">{{ $cartCount }} item · Rp{{ number_format($cartTotal, 0, ',', '.') }}</p>
            </div>
        </a>

        <a href="{{ route('jual.create') }}" class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 hover:border-amber-500/30 transition group">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/15 text-xl shrink-0">📤</span>
            <div>
                <p class="text-sm font-semibold text-white group-hover:text-amber-200">Jual Produk Baru</p>
                <p class="text-xs text-zinc-500">Pasang iklan dengan foto</p>
            </div>
        </a>

        <a href="{{ route('pesanan.index') }}" class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 hover:border-amber-500/30 transition group">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500/15 text-xl shrink-0">📋</span>
            <div>
                <p class="text-sm font-semibold text-white group-hover:text-amber-200">Riwayat Pesanan</p>
                <p class="text-xs text-zinc-500">{{ $orderCount }} pesanan total</p>
            </div>
        </a>

        {{-- Promo banner --}}
        @if($promoProduct)
        <div class="rounded-2xl border border-amber-500/20 bg-gradient-to-br from-amber-500/10 to-transparent p-4">
            <p class="text-xs font-semibold text-amber-400 uppercase tracking-wider mb-2">🔥 Promo Terbaik</p>
            <a href="{{ route('toko.show', $promoProduct) }}" class="group">
                @if($promoProduct->displayImageUrl())
                <div class="aspect-video overflow-hidden rounded-xl mb-3">
                    <img src="{{ $promoProduct->displayImageUrl() }}" alt="{{ $promoProduct->title }}" class="h-full w-full object-cover group-hover:scale-105 transition">
                </div>
                @endif
                <p class="text-sm font-bold text-white group-hover:text-amber-200 line-clamp-1">{{ $promoProduct->title }}</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-xs text-zinc-500 line-through">Rp{{ number_format($promoProduct->price, 0, ',', '.') }}</span>
                    <span class="text-sm font-bold text-amber-300">Rp{{ number_format($promoProduct->effectivePrice(), 0, ',', '.') }}</span>
                </div>
            </a>
        </div>
        @endif
    </div>
</div>

@endsection
