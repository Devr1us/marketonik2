@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1 class="font-display text-3xl font-extrabold text-white">Checkout</h1>
<p class="mt-2 text-sm text-zinc-400">Pilih metode pembayaran. Online = simulasi langsung lunas; offline = menunggu konfirmasi manual.</p>

<div class="mt-8 grid gap-8 lg:grid-cols-2">
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-6">
        <h2 class="font-semibold text-white">Item</h2>
        <ul class="mt-4 space-y-3 text-sm text-zinc-400">
            @foreach($items as $item)
                <li class="flex justify-between gap-4">
                    <span>{{ $item->product->title }} × {{ $item->quantity }}</span>
                    <span class="text-zinc-200">Rp{{ number_format($item->product->effectivePrice() * $item->quantity, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
        <div class="mt-6 border-t border-white/10 pt-4 text-sm">
            <div class="flex justify-between text-zinc-500"><span>Subtotal katalog</span><span class="line-through">Rp{{ number_format($subtotalOriginal, 0, ',', '.') }}</span></div>
            <div class="flex justify-between text-emerald-400"><span>Diskon</span><span>− Rp{{ number_format($hemat, 0, ',', '.') }}</span></div>
            <div class="mt-2 flex justify-between text-lg font-bold text-white"><span>Total</span><span>Rp{{ number_format($subtotalAfter, 0, ',', '.') }}</span></div>
        </div>
    </div>

    <form method="post" action="{{ route('checkout.store') }}" class="rounded-2xl border border-white/10 bg-zinc-900/40 p-6">
        @csrf
        <h2 class="font-semibold text-white">Metode pembayaran</h2>
        <label class="mt-4 flex cursor-pointer items-start gap-3 rounded-xl border border-white/10 p-4 hover:border-amber-500/40">
            <input type="radio" name="payment_method" value="online" class="mt-1" checked>
            <span>
                <span class="block font-medium text-white">Online (simulasi)</span>
                <span class="text-xs text-zinc-500">Gateway demo — status langsung lunas untuk cetak struk.</span>
            </span>
        </label>
        <label class="mt-3 flex cursor-pointer items-start gap-3 rounded-xl border border-white/10 p-4 hover:border-amber-500/40">
            <input type="radio" name="payment_method" value="offline" class="mt-1">
            <span>
                <span class="block font-medium text-white">Offline</span>
                <span class="text-xs text-zinc-500">Transfer bank / bayar di toko — status menunggu konfirmasi.</span>
            </span>
        </label>
        <button type="submit" class="mt-8 w-full rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-sm font-bold text-zinc-950">Bayar & buat pesanan</button>
    </form>
</div>
@endsection
