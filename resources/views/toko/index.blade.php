@extends('layouts.app')

@section('title', 'Katalog Elektronik')

@section('content')
<div class="flex flex-col gap-8 md:flex-row md:items-end md:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Koleksi pilihan</p>
        <h1 class="font-display mt-2 text-3xl font-extrabold text-white md:text-4xl">Elektronik dengan sentuhan <span class="text-amber-400">mewah</span></h1>
        <p class="mt-2 max-w-xl text-sm text-zinc-400">Diskon emas pada produk pilihan. Setiap barang memiliki spesifikasi detail dari penjual.</p>
    </div>
    <form method="get" action="{{ route('toko.index') }}" class="flex w-full max-w-md gap-2">
        <input name="q" value="{{ request('q') }}" placeholder="Cari produk, kota..." class="flex-1 rounded-xl border border-white/10 bg-black/30 px-4 py-2.5 text-sm outline-none focus:border-amber-500/40">
        <button class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/15">Cari</button>
    </form>
</div>

<div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($products as $product)
        <a href="{{ route('toko.show', $product) }}" class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.06] to-transparent p-5 shadow-xl shadow-black/30 transition hover:border-amber-500/30 hover:shadow-amber-500/10">
            @if($product->discount_percent > 0)
                <span class="absolute right-4 top-4 rounded-full bg-amber-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-zinc-950">-{{ $product->discount_percent }}%</span>
            @endif
            <div class="aspect-[4/3] w-full overflow-hidden rounded-xl bg-zinc-800/80">
                @if($product->displayImageUrl())
                    <img src="{{ $product->displayImageUrl() }}" alt="" class="h-full w-full object-cover opacity-90 transition group-hover:scale-105 group-hover:opacity-100">
                @else
                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-900 text-4xl text-zinc-600">◇</div>
                @endif
            </div>
            <h2 class="mt-4 font-display text-lg font-bold text-white group-hover:text-amber-200">{{ $product->title }}</h2>
            <p class="mt-1 line-clamp-2 text-xs text-zinc-500">{{ \Illuminate\Support\Str::limit($product->description, 96) }}</p>
            <p class="mt-2 text-xs text-zinc-500">📍 {{ $product->seller_location }}</p>
            <div class="mt-auto flex items-baseline gap-2 pt-4">
                @if($product->discount_percent > 0)
                    <span class="text-sm text-zinc-500 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
                <span class="text-lg font-bold text-amber-300">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</span>
            </div>
        </a>
    @empty
        <p class="col-span-full text-center text-zinc-500">Belum ada produk.</p>
    @endforelse
</div>

<div class="mt-10">{{ $products->links() }}</div>
@endsection
