@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="grid gap-10 lg:grid-cols-2">
    <div>
        <div class="aspect-square overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/60">
            @if($product->displayImageUrl())
                <img src="{{ $product->displayImageUrl() }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full items-center justify-center bg-gradient-to-br from-zinc-800 to-black text-8xl text-zinc-700">◆</div>
            @endif
        </div>
    </div>
    <div>
        @if($product->discount_percent > 0)
            <span class="inline-flex rounded-full bg-amber-500 px-3 py-1 text-xs font-bold uppercase tracking-wide text-zinc-950">Hemat {{ $product->discount_percent }}%</span>
        @endif
        <h1 class="font-display mt-4 text-3xl font-extrabold text-white md:text-4xl">{{ $product->title }}</h1>
        <p class="mt-3 text-sm leading-relaxed text-zinc-400">{{ $product->description }}</p>
        <p class="mt-4 text-sm text-zinc-500">Lokasi penjual: <span class="text-zinc-200">{{ $product->seller_location }}</span></p>
        <p class="text-sm text-zinc-500">Penjual: <span class="text-zinc-200">{{ $product->seller->name }}</span></p>

        <div class="mt-6 flex flex-wrap items-baseline gap-3">
            @if($product->discount_percent > 0)
                <span class="text-lg text-zinc-500 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
            @endif
            <span class="text-3xl font-bold text-amber-300">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</span>
            <span class="text-xs text-zinc-600">Stok: {{ $product->stock }}</span>
        </div>

        <form class="mt-8 flex flex-wrap items-center gap-3" method="post" action="{{ route('keranjang.add', $product) }}">
            @csrf
            <label class="text-xs text-zinc-500">Jumlah</label>
            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-24 rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm">
            <button type="submit" class="rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-6 py-2.5 text-sm font-bold text-zinc-950 shadow-lg shadow-amber-500/20 hover:brightness-110">Tambah ke keranjang</button>
        </form>

        <div class="mt-10 rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <h2 class="font-display text-lg font-bold text-white">Spesifikasi</h2>
            <dl class="mt-4 space-y-3">
                @foreach($product->specifications as $key => $value)
                    <div class="grid grid-cols-3 gap-2 border-b border-white/5 pb-3 last:border-0">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $key }}</dt>
                        <dd class="col-span-2 text-sm text-zinc-200">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
@endsection
