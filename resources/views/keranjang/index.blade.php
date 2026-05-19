@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Belanja Anda</p>
        <h1 class="font-display mt-1 text-3xl font-extrabold text-white">Keranjang</h1>
        <p class="mt-1 text-sm text-zinc-400">{{ $items->count() }} item dalam keranjang</p>
    </div>
    <a href="{{ route('toko.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300">← Lanjut belanja</a>
</div>

@if($items->isNotEmpty())
<div class="grid gap-8 lg:grid-cols-3">
    {{-- Items --}}
    <div class="space-y-3 lg:col-span-2">
        @foreach($items as $item)
        <div class="flex gap-4 rounded-2xl border border-white/10 bg-zinc-900/40 p-4 hover:border-white/20 transition">
            {{-- Product image --}}
            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-zinc-800">
                @if($item->product->displayImageUrl())
                    <img src="{{ $item->product->displayImageUrl() }}" alt="{{ $item->product->title }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-2xl text-zinc-600">◇</div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <a href="{{ route('toko.show', $item->product) }}" class="font-semibold text-white hover:text-amber-200 line-clamp-1">{{ $item->product->title }}</a>
                <p class="text-xs text-zinc-500 mt-0.5">{{ $item->product->category }} · 📍 {{ $item->product->seller_location }}</p>
                <div class="mt-1 flex items-baseline gap-2">
                    @if($item->product->discount_percent > 0)
                        <span class="text-xs text-zinc-500 line-through">Rp{{ number_format($item->product->price, 0, ',', '.') }}</span>
                        <span class="rounded-full bg-amber-500/20 px-1.5 py-0.5 text-[9px] font-bold text-amber-300">-{{ $item->product->discount_percent }}%</span>
                    @endif
                    <span class="text-sm font-bold text-amber-300">Rp{{ number_format($item->product->effectivePrice(), 0, ',', '.') }}</span>
                    <span class="text-xs text-zinc-600">/ unit</span>
                </div>

                {{-- Qty + actions --}}
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <form method="post" action="{{ route('keranjang.update', $item) }}" class="flex items-center gap-1.5">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center rounded-lg border border-white/10 bg-black/30">
                            <span class="px-2 text-xs text-zinc-500">Qty</span>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                class="w-14 bg-transparent py-1.5 text-center text-sm font-semibold text-white outline-none">
                        </div>
                        <button class="rounded-lg border border-white/15 px-2.5 py-1.5 text-xs text-zinc-400 hover:border-amber-500/40 hover:text-amber-300 transition">
                            Ubah
                        </button>
                    </form>

                    <form method="post" action="{{ route('keranjang.destroy', $item) }}" onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-lg border border-rose-500/20 px-2.5 py-1.5 text-xs text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition">
                            🗑 Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Line total --}}
            <div class="shrink-0 text-right hidden sm:block">
                <p class="text-xs text-zinc-600">Subtotal</p>
                <p class="font-display font-bold text-white">Rp{{ number_format($item->product->effectivePrice() * $item->quantity, 0, ',', '.') }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Summary --}}
    <div class="h-fit rounded-2xl border border-amber-500/20 bg-amber-500/5 p-6 sticky top-24">
        <p class="text-xs font-semibold uppercase tracking-wider text-amber-200/80 mb-4">Ringkasan Belanja</p>

        <div class="space-y-2 text-sm">
            <div class="flex justify-between text-zinc-400">
                <span>Subtotal ({{ $items->count() }} item)</span>
                <span>Rp{{ number_format($subtotalOriginal, 0, ',', '.') }}</span>
            </div>
            @if($hemat > 0)
            <div class="flex justify-between text-emerald-400">
                <span>Total hemat</span>
                <span>− Rp{{ number_format($hemat, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between border-t border-white/10 pt-3 text-lg font-bold text-white">
                <span>Total</span>
                <span>Rp{{ number_format($subtotalAfter, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($hemat > 0)
        <div class="mt-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300">
            🎉 Anda hemat <span class="font-bold">Rp{{ number_format($hemat, 0, ',', '.') }}</span> dari diskon!
        </div>
        @endif

        <a href="{{ route('checkout.create') }}" class="mt-5 block rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3.5 text-center text-sm font-bold text-zinc-950 shadow-lg shadow-amber-500/20 hover:brightness-110 transition">
            Lanjut ke Checkout →
        </a>
        <a href="{{ route('toko.index') }}" class="mt-2 block rounded-xl border border-white/15 py-3 text-center text-xs font-semibold text-zinc-400 hover:border-white/25 hover:text-zinc-300 transition">
            Lanjut Belanja
        </a>
    </div>
</div>

@else
{{-- Empty state --}}
<div class="py-20 text-center">
    <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full border border-white/10 bg-white/[0.02] text-5xl">🛒</div>
    <h2 class="text-xl font-semibold text-zinc-300">Keranjang masih kosong</h2>
    <p class="mt-2 text-sm text-zinc-500">Temukan produk elektronik pilihan dan tambahkan ke keranjang</p>
    <a href="{{ route('toko.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-6 py-3 text-sm font-bold text-zinc-950 hover:brightness-110 transition">
        🛍️ Mulai Belanja
    </a>
</div>
@endif

@endsection
