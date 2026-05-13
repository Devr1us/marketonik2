@extends('layouts.app')

@section('title', 'Pesanan '.$order->order_code)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <a href="{{ route('pesanan.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300">← Kembali ke riwayat</a>
        <h1 class="font-display mt-2 text-2xl font-extrabold text-white md:text-3xl">{{ $order->order_code }}</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y · H:i') }} WIB</p>
    </div>
    <div class="flex gap-2">
        <span class="rounded-full border border-white/15 px-3 py-1 text-xs capitalize text-zinc-300">{{ $order->payment_method }}</span>
        <span class="rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">{{ $order->payment_status }}</span>
    </div>
</div>

<div class="mt-8 grid gap-8 lg:grid-cols-2">
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 p-6">
        <h2 class="font-display text-lg font-bold text-white">Item pesanan</h2>
        <ul class="mt-4 divide-y divide-white/10">
            @foreach($order->items as $line)
                <li class="flex justify-between gap-4 py-3 text-sm">
                    <span class="text-zinc-300">{{ $line->product_title }} <span class="text-zinc-600">× {{ $line->quantity }}</span></span>
                    <span class="shrink-0 text-amber-200">Rp{{ number_format($line->line_total, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-6">
        <h2 class="font-display text-lg font-bold text-white">Ringkasan pembayaran</h2>
        <dl class="mt-4 space-y-2 text-sm">
            <div class="flex justify-between text-zinc-400"><dt>Subtotal katalog</dt><dd>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between text-emerald-400"><dt>Total diskon</dt><dd>− Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between border-t border-white/10 pt-3 text-lg font-bold text-white"><dt>Total</dt><dd>Rp{{ number_format($order->total, 0, ',', '.') }}</dd></div>
        </dl>
        <p class="mt-4 rounded-lg border border-white/10 bg-black/20 p-3 text-xs text-zinc-400">{{ $order->payment_note }}</p>
        <a href="{{ route('pesanan.struk', $order) }}" class="mt-6 block rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-center text-sm font-bold text-zinc-950 hover:brightness-110">Cetak struk</a>
    </div>
</div>
@endsection
