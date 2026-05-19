@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="mb-8">
    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Langkah Terakhir</p>
    <h1 class="font-display mt-1 text-3xl font-extrabold text-white">Checkout</h1>
    <p class="mt-1 text-sm text-zinc-400">Periksa pesanan dan pilih metode pembayaran</p>
</div>

{{-- Progress steps --}}
<div class="mb-8 flex items-center gap-0">
    @foreach(['Keranjang', 'Checkout', 'Konfirmasi'] as $i => $step)
    <div class="flex flex-1 flex-col items-center">
        <div class="flex items-center w-full">
            @if($i > 0)<div class="flex-1 h-0.5 {{ $i <= 1 ? 'bg-amber-500' : 'bg-white/10' }}"></div>@endif
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $i === 1 ? 'bg-amber-500 text-zinc-950 font-bold' : ($i < 1 ? 'bg-amber-500/30 text-amber-300' : 'bg-white/10 text-zinc-600') }} text-xs">
                {{ $i < 1 ? '✓' : $i + 1 }}
            </div>
            @if($i < 2)<div class="flex-1 h-0.5 {{ $i < 1 ? 'bg-amber-500' : 'bg-white/10' }}"></div>@endif
        </div>
        <span class="mt-1.5 text-[10px] {{ $i === 1 ? 'text-amber-300 font-semibold' : 'text-zinc-600' }}">{{ $step }}</span>
    </div>
    @endforeach
</div>

<div class="grid gap-8 lg:grid-cols-2">

    {{-- Order summary --}}
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-6">
        <h2 class="font-display text-base font-bold text-white mb-4">Ringkasan Pesanan</h2>
        <ul class="space-y-3">
            @foreach($items as $item)
            <li class="flex items-center gap-3">
                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg bg-zinc-800">
                    @if($item->product->displayImageUrl())
                        <img src="{{ $item->product->displayImageUrl() }}" alt="{{ $item->product->title }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full items-center justify-center text-lg text-zinc-600">◇</div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-zinc-200 line-clamp-1">{{ $item->product->title }}</p>
                    <p class="text-xs text-zinc-500">× {{ $item->quantity }}</p>
                </div>
                <span class="text-sm font-semibold text-amber-200 shrink-0">Rp{{ number_format($item->product->effectivePrice() * $item->quantity, 0, ',', '.') }}</span>
            </li>
            @endforeach
        </ul>

        <div class="mt-5 border-t border-white/10 pt-4 space-y-2 text-sm">
            <div class="flex justify-between text-zinc-400">
                <span>Subtotal katalog</span>
                <span class="line-through">Rp{{ number_format($subtotalOriginal, 0, ',', '.') }}</span>
            </div>
            @if($hemat > 0)
            <div class="flex justify-between text-emerald-400">
                <span>Total diskon</span>
                <span>− Rp{{ number_format($hemat, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between text-lg font-bold text-white border-t border-white/10 pt-2">
                <span>Total Bayar</span>
                <span>Rp{{ number_format($subtotalAfter, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($hemat > 0)
        <div class="mt-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300">
            🎉 Hemat <span class="font-bold">Rp{{ number_format($hemat, 0, ',', '.') }}</span> dari diskon produk!
        </div>
        @endif
    </div>

    {{-- Checkout form --}}
    <form method="post" action="{{ route('checkout.store') }}" class="space-y-5">
        @csrf

        {{-- Shipping address --}}
        <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-5">
            <h2 class="font-display text-base font-bold text-white mb-4">Alamat Pengiriman</h2>
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Alamat Lengkap</label>
                <textarea name="shipping_address" rows="3" required placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Kode Pos"
                    class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-zinc-300 resize-none focus:border-amber-500/40 focus:ring-2 focus:ring-amber-500/10 outline-none">{{ old('shipping_address') }}</textarea>
            </div>
        </div>

        {{-- Payment method --}}
        <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-5">
            <h2 class="font-display text-base font-bold text-white mb-4">Metode Pembayaran</h2>
            <div class="space-y-3">
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white/10 p-4 hover:border-amber-500/40 transition has-[:checked]:border-amber-500/50 has-[:checked]:bg-amber-500/5">
                    <input type="radio" name="payment_method" value="online" class="mt-1 accent-amber-500" checked>
                    <span>
                        <span class="flex items-center gap-2">
                            <span class="text-lg">💳</span>
                            <span class="block font-semibold text-white">Pembayaran Online</span>
                        </span>
                        <span class="mt-0.5 block text-xs text-zinc-500">Gateway demo — status langsung lunas, struk bisa dicetak segera.</span>
                    </span>
                </label>
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white/10 p-4 hover:border-amber-500/40 transition has-[:checked]:border-amber-500/50 has-[:checked]:bg-amber-500/5">
                    <input type="radio" name="payment_method" value="offline" class="mt-1 accent-amber-500">
                    <span>
                        <span class="flex items-center gap-2">
                            <span class="text-lg">🏦</span>
                            <span class="block font-semibold text-white">Transfer Bank / COD</span>
                        </span>
                        <span class="mt-0.5 block text-xs text-zinc-500">Bayar via transfer atau langsung di toko — status menunggu konfirmasi admin.</span>
                    </span>
                </label>
            </div>
        </div>

        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-4 text-sm font-bold text-zinc-950 shadow-lg shadow-amber-500/20 hover:brightness-110 transition">
            ✅ Konfirmasi & Buat Pesanan
        </button>
        <a href="{{ route('keranjang.index') }}" class="block text-center text-xs text-zinc-500 hover:text-zinc-400">← Kembali ke keranjang</a>
    </form>
</div>

@endsection
