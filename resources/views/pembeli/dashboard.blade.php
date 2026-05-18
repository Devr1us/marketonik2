@extends('layouts.app')

@section('title', 'Dashboard Pembeli')

@section('content')
<div>
    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Selamat datang</p>
    <h1 class="font-display mt-2 text-3xl font-extrabold text-white md:text-4xl">Halo, {{ auth()->user()->name }}</h1>
    <p class="mt-2 text-sm text-zinc-400">Dashboard pembeli — ringkasan belanja Anda.</p>
</div>

<div class="mt-10 grid gap-4 sm:grid-cols-3">
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-5">
        <p class="text-xs text-zinc-500">Item keranjang</p>
        <p class="font-display mt-2 text-3xl font-bold text-amber-200">{{ $cartCount }}</p>
        <a href="{{ route('keranjang.index') }}" class="mt-3 inline-block text-xs font-semibold text-amber-400 hover:text-amber-300">Lihat keranjang →</a>
    </div>
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-5">
        <p class="text-xs text-zinc-500">Total pesanan</p>
        <p class="font-display mt-2 text-3xl font-bold text-white">{{ $orderCount }}</p>
        <a href="{{ route('pesanan.index') }}" class="mt-3 inline-block text-xs font-semibold text-amber-400 hover:text-amber-300">Riwayat pesanan →</a>
    </div>
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-5">
        <p class="text-xs text-zinc-500">Estimasi keranjang</p>
        <p class="font-display mt-2 text-2xl font-bold text-emerald-200">Rp{{ number_format($cartTotal, 0, ',', '.') }}</p>
        <a href="{{ route('toko.index') }}" class="mt-3 inline-block text-xs font-semibold text-amber-400 hover:text-amber-300">Belanja lagi →</a>
    </div>
</div>

@if($recentOrders->isNotEmpty())
<section class="mt-10">
    <h2 class="font-display text-lg font-bold text-white">Pesanan terakhir</h2>
    <div class="mt-4 space-y-3">
        @foreach($recentOrders as $order)
            <a href="{{ route('pesanan.show', $order) }}" class="block rounded-xl border border-white/10 bg-white/[0.02] p-4 hover:border-amber-500/30">
                <p class="font-mono text-sm text-amber-200">{{ $order->order_code }}</p>
                <p class="mt-1 text-xs text-zinc-500">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                <p class="mt-2 font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
            </a>
        @endforeach
    </div>
</section>
@endif
@endsection
