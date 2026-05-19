@extends('layouts.app')

@section('title', $product->title)

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6 flex items-center gap-2 text-xs text-zinc-500">
    <a href="{{ route('pembeli.dashboard') }}" class="hover:text-amber-300">Beranda</a>
    <span>›</span>
    <a href="{{ route('toko.index') }}" class="hover:text-amber-300">Katalog</a>
    <span>›</span>
    <a href="{{ route('toko.index', ['kategori' => $product->category]) }}" class="hover:text-amber-300">{{ $product->category }}</a>
    <span>›</span>
    <span class="text-zinc-400 line-clamp-1">{{ $product->title }}</span>
</nav>

<div class="grid gap-10 lg:grid-cols-2">
    {{-- Image --}}
    <div>
        <div class="relative aspect-square overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/60 shadow-2xl shadow-black/40">
            @if($product->discount_percent > 0)
                <span class="absolute right-4 top-4 z-10 rounded-full bg-white px-3 py-1.5 text-xs font-bold text-zinc-950 shadow-xl">Hemat {{ $product->discount_percent }}%</span>
            @endif
            @if($product->stock <= 3 && $product->stock > 0)
                <span class="absolute left-4 top-4 z-10 rounded-full bg-rose-500/90 px-3 py-1.5 text-xs font-bold text-white">Stok tersisa {{ $product->stock }}</span>
            @endif
            @if($product->displayImageUrl())
                <img src="{{ $product->displayImageUrl() }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full items-center justify-center bg-gradient-to-br from-zinc-800 to-black text-8xl text-zinc-700">◆</div>
            @endif
        </div>

        {{-- Share --}}
        <div class="mt-4 flex items-center gap-2">
            <span class="text-xs text-zinc-600">Bagikan:</span>
            <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link disalin!'))" class="rounded-lg border border-white/10 px-3 py-1.5 text-xs text-zinc-400 hover:border-amber-500/40 hover:text-amber-300 transition">
                🔗 Salin Link
            </button>
        </div>
    </div>

    {{-- Info --}}
    <div>
        {{-- Category badge --}}
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('toko.index', ['kategori' => $product->category]) }}" class="inline-flex rounded-full border border-white/15 px-3 py-1 text-xs text-zinc-400 hover:border-amber-500/30 hover:text-amber-300 transition">
                {{ $product->category }}
            </a>
            @if($product->discount_percent > 0)
                <span class="inline-flex rounded-full bg-amber-500 px-3 py-1 text-xs font-bold text-zinc-950">Hemat {{ $product->discount_percent }}%</span>
            @endif
        </div>

        <h1 class="font-display mt-3 text-3xl font-extrabold text-white md:text-4xl leading-tight">{{ $product->title }}</h1>
        <p class="mt-3 text-sm leading-relaxed text-zinc-400">{{ $product->description }}</p>

        {{-- Seller info --}}
        <div class="mt-4 flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.02] p-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-sm font-bold text-zinc-950 shrink-0">
                {{ strtoupper(substr($product->seller->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-xs text-zinc-500">Dijual oleh</p>
                <p class="text-sm font-semibold text-white">{{ $product->seller->name }}</p>
                <p class="text-xs text-zinc-500">📍 {{ $product->seller_location }}</p>
            </div>
            @if($sellerProducts->isNotEmpty())
            <a href="{{ route('toko.index', ['q' => $product->seller->name]) }}" class="ml-auto text-xs text-amber-400 hover:text-amber-300 shrink-0">
                Lihat semua →
            </a>
            @endif
        </div>

        {{-- Price --}}
        <div class="mt-6 flex flex-wrap items-baseline gap-3">
            @if($product->discount_percent > 0)
                <span class="text-xl text-zinc-500 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
            @endif
            <span class="text-4xl font-bold text-amber-300">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</span>
        </div>
        @if($product->discount_percent > 0)
        <p class="mt-1 text-sm text-emerald-400">
            Hemat Rp{{ number_format($product->price - $product->effectivePrice(), 0, ',', '.') }} dari harga normal
        </p>
        @endif

        {{-- Stock indicator --}}
        <div class="mt-3 flex items-center gap-2">
            @if($product->stock > 10)
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                <span class="text-xs text-emerald-400">Stok tersedia ({{ $product->stock }} unit)</span>
            @elseif($product->stock > 0)
                <span class="h-2 w-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span class="text-xs text-yellow-400">Stok terbatas — tersisa {{ $product->stock }} unit</span>
            @else
                <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                <span class="text-xs text-rose-400">Stok habis</span>
            @endif
        </div>

        {{-- Add to cart --}}
        <form class="mt-6 flex flex-wrap items-center gap-3" method="post" action="{{ route('keranjang.add', $product) }}">
            @csrf
            <div class="flex items-center gap-2 rounded-xl border border-white/10 bg-black/30 px-3 py-2">
                <label class="text-xs text-zinc-500">Jumlah</label>
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                    class="w-16 bg-transparent text-center text-sm font-semibold text-white outline-none">
            </div>
            <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-6 py-3 text-sm font-bold text-zinc-950 shadow-lg shadow-amber-500/20 hover:brightness-110 transition">
                🛒 Tambah ke Keranjang
            </button>
        </form>

        {{-- Specs --}}
        @if(!empty($product->specifications))
        <div class="mt-8 rounded-2xl border border-white/10 bg-white/[0.03] p-5">
            <h2 class="font-display text-base font-bold text-white mb-4">Spesifikasi Teknis</h2>
            <dl class="space-y-2">
                @foreach($product->specifications as $key => $value)
                <div class="grid grid-cols-5 gap-2 border-b border-white/5 pb-2 last:border-0 last:pb-0">
                    <dt class="col-span-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $key }}</dt>
                    <dd class="col-span-3 text-sm text-zinc-200">{{ $value }}</dd>
                </div>
                @endforeach
            </dl>
        </div>
        @endif
    </div>
</div>

{{-- Produk dari penjual yang sama --}}
@if($sellerProducts->isNotEmpty())
<section class="mt-14">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-xl font-bold text-white">Produk Lain dari Penjual Ini</h2>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($sellerProducts as $p)
        <a href="{{ route('toko.show', $p) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] p-3 hover:border-amber-500/30 transition">
            <div class="aspect-square overflow-hidden rounded-xl bg-zinc-800/80">
                @if($p->displayImageUrl())
                    <img src="{{ $p->displayImageUrl() }}" alt="{{ $p->title }}" class="h-full w-full object-cover group-hover:scale-105 transition">
                @else
                    <div class="flex h-full items-center justify-center text-3xl text-zinc-600">◇</div>
                @endif
            </div>
            <p class="mt-2 text-xs font-semibold text-white group-hover:text-amber-200 line-clamp-1">{{ $p->title }}</p>
            <p class="text-xs font-bold text-amber-300 mt-1">Rp{{ number_format($p->effectivePrice(), 0, ',', '.') }}</p>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- Produk terkait --}}
@if($related->isNotEmpty())
<section class="mt-14">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-xl font-bold text-white">Produk Serupa</h2>
        <a href="{{ route('toko.index', ['kategori' => $product->category]) }}" class="text-xs text-amber-400 hover:text-amber-300">Lihat semua →</a>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($related as $p)
        <a href="{{ route('toko.show', $p) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] p-3 hover:border-amber-500/30 transition">
            <div class="relative aspect-square overflow-hidden rounded-xl bg-zinc-800/80">
                @if($p->discount_percent > 0)
                    <span class="absolute right-2 top-2 z-10 rounded-full bg-amber-400 px-2 py-0.5 text-[9px] font-bold text-zinc-950">-{{ $p->discount_percent }}%</span>
                @endif
                @if($p->displayImageUrl())
                    <img src="{{ $p->displayImageUrl() }}" alt="{{ $p->title }}" class="h-full w-full object-cover group-hover:scale-105 transition">
                @else
                    <div class="flex h-full items-center justify-center text-3xl text-zinc-600">◇</div>
                @endif
            </div>
            <p class="mt-2 text-xs font-semibold text-white group-hover:text-amber-200 line-clamp-1">{{ $p->title }}</p>
            <div class="flex items-baseline gap-1 mt-1">
                @if($p->discount_percent > 0)
                    <span class="text-[10px] text-zinc-500 line-through">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                @endif
                <span class="text-xs font-bold text-amber-300">Rp{{ number_format($p->effectivePrice(), 0, ',', '.') }}</span>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

@endsection
