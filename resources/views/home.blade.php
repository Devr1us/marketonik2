@extends('layouts.app')

@section('title', 'Marketonik — Elektronik Premium')

@section('content')

{{-- Hero Section --}}
<section class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-zinc-900/80 via-[#0d0e18] to-amber-950/20 px-6 py-16 md:px-12 md:py-24">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full bg-amber-500/10 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 h-60 w-60 rounded-full bg-violet-500/10 blur-3xl"></div>
    </div>
    <div class="relative grid gap-10 lg:grid-cols-2 lg:items-center">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-300">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                Koleksi Terbaru 2026
            </span>
            <h1 class="font-display mt-4 text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                Elektronik <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-amber-600 bg-clip-text text-transparent">Premium</span><br>untuk Anda
            </h1>
            <p class="mt-4 max-w-lg text-base text-zinc-400 leading-relaxed">
                Temukan ribuan produk elektronik pilihan dengan harga terbaik. Dari laptop gaming hingga audio hi-fi — semua ada di Marketonik.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('toko.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-6 py-3 text-sm font-bold text-zinc-950 shadow-lg shadow-amber-500/25 hover:brightness-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Belanja Sekarang
                </a>
                <a href="{{ route('jual.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/15 px-6 py-3 text-sm font-semibold text-zinc-300 hover:border-amber-500/40 hover:text-amber-200 transition">
                    Jual Produk
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            {{-- Stats --}}
            <div class="mt-10 flex flex-wrap gap-6">
                <div>
                    <p class="font-display text-2xl font-bold text-white">{{ number_format($stats['products']) }}+</p>
                    <p class="text-xs text-zinc-500">Produk Aktif</p>
                </div>
                <div class="border-l border-white/10 pl-6">
                    <p class="font-display text-2xl font-bold text-white">{{ number_format($stats['sellers']) }}+</p>
                    <p class="text-xs text-zinc-500">Penjual</p>
                </div>
                <div class="border-l border-white/10 pl-6">
                    <p class="font-display text-2xl font-bold text-white">{{ number_format($stats['orders']) }}+</p>
                    <p class="text-xs text-zinc-500">Transaksi</p>
                </div>
            </div>
        </div>
        {{-- Featured product image --}}
        @if($featuredProduct)
        <div class="relative">
            <div class="relative aspect-square max-w-sm mx-auto overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/60 shadow-2xl shadow-black/50">
                @if($featuredProduct->discount_percent > 0)
                    <span class="absolute right-4 top-4 z-10 rounded-full bg-amber-400 px-3 py-1 text-xs font-bold text-zinc-950">Hemat {{ $featuredProduct->discount_percent }}%</span>
                @endif
                @if($featuredProduct->displayImageUrl())
                    <img src="{{ $featuredProduct->displayImageUrl() }}" alt="{{ $featuredProduct->title }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-8xl text-zinc-700">◆</div>
                @endif
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                    <p class="text-xs text-zinc-400">Produk Unggulan</p>
                    <p class="font-display font-bold text-white">{{ $featuredProduct->title }}</p>
                    <p class="text-amber-300 font-bold">Rp{{ number_format($featuredProduct->effectivePrice(), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- Promo Banner --}}
@if($promoProducts->isNotEmpty())
<section class="mt-10">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Penawaran Terbatas</p>
            <h2 class="font-display text-2xl font-bold text-white">Diskon Spesial Hari Ini</h2>
        </div>
        <a href="{{ route('toko.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300">Lihat semua →</a>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($promoProducts as $p)
        <a href="{{ route('toko.show', $p) }}" class="group relative overflow-hidden rounded-2xl border border-amber-500/20 bg-gradient-to-b from-amber-500/5 to-transparent p-4 hover:border-amber-500/40 transition">
            <div class="relative aspect-square overflow-hidden rounded-xl bg-zinc-800/80 mb-3">
                <span class="absolute right-2 top-2 z-10 rounded-full bg-amber-400 px-2 py-0.5 text-[10px] font-bold text-zinc-950">-{{ $p->discount_percent }}%</span>
                @if($p->displayImageUrl())
                    <img src="{{ $p->displayImageUrl() }}" alt="{{ $p->title }}" class="h-full w-full object-cover group-hover:scale-105 transition">
                @else
                    <div class="flex h-full items-center justify-center text-4xl text-zinc-600">◇</div>
                @endif
            </div>
            <p class="text-xs text-zinc-500 truncate">{{ $p->category }}</p>
            <p class="text-sm font-semibold text-white group-hover:text-amber-200 line-clamp-1">{{ $p->title }}</p>
            <div class="mt-1 flex items-baseline gap-2">
                <span class="text-xs text-zinc-500 line-through">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                <span class="text-sm font-bold text-amber-300">Rp{{ number_format($p->effectivePrice(), 0, ',', '.') }}</span>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- Kategori --}}
<section class="mt-12">
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Jelajahi</p>
        <h2 class="font-display text-2xl font-bold text-white">Kategori Produk</h2>
    </div>
    @php
    $categoryIcons = [
        'Laptop & Komputer' => ['icon' => '💻', 'color' => 'from-blue-500/20 to-blue-600/5 border-blue-500/20'],
        'Smartphone'        => ['icon' => '📱', 'color' => 'from-emerald-500/20 to-emerald-600/5 border-emerald-500/20'],
        'Audio & Headphone' => ['icon' => '🎧', 'color' => 'from-violet-500/20 to-violet-600/5 border-violet-500/20'],
        'Kamera & Foto'     => ['icon' => '📷', 'color' => 'from-rose-500/20 to-rose-600/5 border-rose-500/20'],
        'TV & Monitor'      => ['icon' => '🖥️', 'color' => 'from-cyan-500/20 to-cyan-600/5 border-cyan-500/20'],
        'Gaming'            => ['icon' => '🎮', 'color' => 'from-fuchsia-500/20 to-fuchsia-600/5 border-fuchsia-500/20'],
        'Aksesoris'         => ['icon' => '🔌', 'color' => 'from-amber-500/20 to-amber-600/5 border-amber-500/20'],
        'Lainnya'           => ['icon' => '📦', 'color' => 'from-zinc-500/20 to-zinc-600/5 border-zinc-500/20'],
    ];
    @endphp
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-8">
        @foreach(\App\Models\Product::CATEGORIES as $cat)
        @php $ci = $categoryIcons[$cat] ?? ['icon' => '📦', 'color' => 'from-zinc-500/20 to-zinc-600/5 border-zinc-500/20']; @endphp
        <a href="{{ route('toko.index', ['kategori' => $cat]) }}" class="group flex flex-col items-center gap-2 rounded-2xl border bg-gradient-to-b {{ $ci['color'] }} p-4 text-center hover:scale-105 transition">
            <span class="text-3xl">{{ $ci['icon'] }}</span>
            <span class="text-xs font-medium text-zinc-300 group-hover:text-white leading-tight">{{ $cat }}</span>
            @if(isset($categoryCounts[$cat]) && $categoryCounts[$cat] > 0)
                <span class="text-[10px] text-zinc-600">{{ $categoryCounts[$cat] }} produk</span>
            @endif
        </a>
        @endforeach
    </div>
</section>

{{-- Produk Terbaru --}}
<section class="mt-12">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Baru Ditambahkan</p>
            <h2 class="font-display text-2xl font-bold text-white">Produk Terbaru</h2>
        </div>
        <a href="{{ route('toko.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300">Lihat semua →</a>
    </div>
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($latestProducts as $product)
        <a href="{{ route('toko.show', $product) }}" class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.06] to-transparent p-4 shadow-xl shadow-black/30 transition hover:border-amber-500/30 hover:shadow-amber-500/10">
            <div class="relative aspect-[4/3] w-full overflow-hidden rounded-xl bg-zinc-800/80">
                @if($product->discount_percent > 0)
                    <span class="absolute right-3 top-3 z-10 rounded-full bg-white px-2.5 py-1 text-[10px] font-bold text-zinc-950 shadow-lg">-{{ $product->discount_percent }}%</span>
                @endif
                @if($product->displayImageUrl())
                    <img src="{{ $product->displayImageUrl() }}" alt="{{ $product->title }}" class="h-full w-full object-cover opacity-90 transition group-hover:scale-105 group-hover:opacity-100">
                @else
                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-900 text-4xl text-zinc-600">◇</div>
                @endif
            </div>
            <div class="mt-3 flex items-center gap-2">
                <span class="rounded-full border border-white/10 px-2 py-0.5 text-[10px] text-zinc-500">{{ $product->category }}</span>
                <span class="text-[10px] text-zinc-600">📍 {{ $product->seller_location }}</span>
            </div>
            <h3 class="mt-2 font-display text-base font-bold text-white group-hover:text-amber-200 line-clamp-1">{{ $product->title }}</h3>
            <p class="mt-1 line-clamp-2 text-xs text-zinc-500">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
            <div class="mt-auto flex items-baseline gap-2 pt-3">
                @if($product->discount_percent > 0)
                    <span class="text-xs text-zinc-500 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
                <span class="text-base font-bold text-amber-300">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</span>
            </div>
        </a>
        @empty
        <div class="col-span-full py-12 text-center text-zinc-500">
            <p class="text-4xl mb-3">📦</p>
            <p>Belum ada produk. <a href="{{ route('jual.create') }}" class="text-amber-400 hover:underline">Jual produk pertama Anda</a></p>
        </div>
        @endforelse
    </div>
</section>

{{-- Why Marketonik --}}
<section class="mt-16 rounded-3xl border border-white/10 bg-gradient-to-br from-white/[0.03] to-transparent p-8 md:p-12">
    <div class="text-center mb-10">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Keunggulan Kami</p>
        <h2 class="font-display mt-2 text-2xl font-bold text-white md:text-3xl">Kenapa Pilih Marketonik?</h2>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach([
            ['icon' => '🛡️', 'title' => 'Produk Terjamin', 'desc' => 'Setiap produk diverifikasi keaslian dan kualitasnya oleh tim kami.'],
            ['icon' => '⚡', 'title' => 'Pengiriman Cepat', 'desc' => 'Pengiriman ke seluruh Indonesia dengan estimasi 1-3 hari kerja.'],
            ['icon' => '💳', 'title' => 'Pembayaran Aman', 'desc' => 'Transaksi terenkripsi dengan berbagai metode pembayaran tersedia.'],
            ['icon' => '🔄', 'title' => 'Garansi Resmi', 'desc' => 'Semua produk dilengkapi garansi resmi dari produsen atau toko.'],
        ] as $feat)
        <div class="flex flex-col items-center text-center gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <span class="text-4xl">{{ $feat['icon'] }}</span>
            <p class="font-display font-bold text-white">{{ $feat['title'] }}</p>
            <p class="text-xs text-zinc-500 leading-relaxed">{{ $feat['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

@endsection
