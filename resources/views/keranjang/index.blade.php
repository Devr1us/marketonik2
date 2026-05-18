@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<h1 class="font-display text-3xl font-extrabold text-white">Keranjang</h1>
<p class="mt-2 text-sm text-zinc-400">Ringkasan harga sudah memperhitungkan diskon per produk.</p>

<div class="mt-8 grid gap-8 lg:grid-cols-3">
    <div class="space-y-4 lg:col-span-2">
        @forelse($items as $item)
            <div class="flex flex-col gap-4 rounded-2xl border border-white/10 bg-zinc-900/40 p-4 sm:flex-row sm:items-center">
                <div class="flex-1">
                    <a href="{{ route('toko.show', $item->product) }}" class="font-semibold text-white hover:text-amber-200">{{ $item->product->title }}</a>
                    <p class="text-xs text-zinc-500">{{ $item->product->seller_location }}</p>
                    <p class="mt-1 text-sm text-amber-300">Rp{{ number_format($item->product->effectivePrice(), 0, ',', '.') }} <span class="text-zinc-600">/ unit</span></p>
                </div>
                <form method="post" action="{{ route('keranjang.update', $item) }}" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-20 rounded-lg border border-white/10 bg-black/40 px-2 py-1 text-sm">
                    <button class="rounded-lg border border-white/15 px-3 py-1 text-xs text-zinc-300 hover:border-amber-500/40">Ubah</button>
                </form>
                <form method="post" action="{{ route('keranjang.destroy', $item) }}" onsubmit="return confirm('Hapus item?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-xs text-rose-400 hover:text-rose-300">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-zinc-500">Keranjang kosong. <a class="text-amber-400 hover:underline" href="{{ route('toko.index') }}">Belanja</a></p>
        @endforelse
    </div>
    <div class="h-fit rounded-2xl border border-amber-500/20 bg-amber-500/5 p-6">
        <p class="text-xs uppercase tracking-wide text-amber-200/80">Ringkasan</p>
        <p class="mt-2 text-sm text-zinc-400">Sebelum diskon <span class="text-zinc-500 line-through">Rp{{ number_format($subtotalOriginal, 0, ',', '.') }}</span></p>
        <p class="text-sm text-emerald-300">Anda hemat Rp{{ number_format($hemat, 0, ',', '.') }}</p>
        <p class="mt-4 font-display text-2xl font-bold text-white">Rp{{ number_format($subtotalAfter, 0, ',', '.') }}</p>
        <a href="{{ route('checkout.create') }}" class="mt-6 block rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-center text-sm font-bold text-zinc-950 {{ $items->isEmpty() ? 'pointer-events-none opacity-40' : '' }}">Lanjut checkout</a>
    </div>
</div>
@endsection
