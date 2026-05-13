@extends('layouts.app')

@section('title', 'Riwayat pesanan')

@section('content')
<div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Transaksi Anda</p>
        <h1 class="font-display mt-2 text-3xl font-extrabold text-white md:text-4xl">Riwayat pesanan</h1>
        <p class="mt-2 text-sm text-zinc-400">Semua pesanan yang pernah Anda buat dari akun ini.</p>
    </div>
</div>

<div class="mt-10 space-y-4">
    @forelse($orders as $order)
        <article class="flex flex-col gap-4 rounded-2xl border border-white/10 bg-zinc-900/40 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-mono text-sm font-semibold text-amber-200">{{ $order->order_code }}</p>
                <p class="mt-1 text-xs text-zinc-500">{{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y · H:i') }} WIB · {{ $order->items_count }} item</p>
                <div class="mt-2 flex flex-wrap gap-2 text-xs">
                    <span class="rounded-full border border-white/15 px-2 py-0.5 capitalize text-zinc-300">{{ $order->payment_method }}</span>
                    <span class="rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 font-semibold text-emerald-200">{{ $order->payment_status }}</span>
                </div>
            </div>
            <div class="flex flex-col items-start gap-3 sm:items-end">
                <p class="font-display text-xl font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('pesanan.show', $order) }}" class="rounded-lg border border-white/20 px-3 py-1.5 text-xs font-semibold text-zinc-200 hover:border-amber-500/40 hover:text-amber-200">Detail</a>
                    <a href="{{ route('pesanan.struk', $order) }}" class="rounded-lg bg-gradient-to-r from-amber-400 to-amber-600 px-3 py-1.5 text-xs font-bold text-zinc-950 hover:brightness-110">Struk</a>
                </div>
            </div>
        </article>
    @empty
        <div class="rounded-2xl border border-dashed border-white/15 bg-white/[0.02] py-16 text-center">
            <p class="text-zinc-500">Belum ada pesanan.</p>
            <a href="{{ route('toko.index') }}" class="mt-4 inline-block text-sm font-semibold text-amber-400 hover:text-amber-300">Mulai belanja</a>
        </div>
    @endforelse
</div>

<div class="mt-10">{{ $orders->links() }}</div>
@endsection
