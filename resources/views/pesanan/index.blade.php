@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">Transaksi Anda</p>
        <h1 class="font-display mt-1 text-3xl font-extrabold text-white md:text-4xl">Riwayat Pesanan</h1>
        <p class="mt-1 text-sm text-zinc-400">Semua pesanan dari akun ini · {{ $orders->total() }} total</p>
    </div>
    <a href="{{ route('toko.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/15 px-4 py-2.5 text-sm font-semibold text-zinc-300 hover:border-amber-500/40 hover:text-amber-200 transition">
        🛍️ Belanja Lagi
    </a>
</div>

<div class="mt-8 space-y-4">
    @forelse($orders as $order)
    <article class="rounded-2xl border border-white/10 bg-zinc-900/40 p-5 hover:border-amber-500/20 transition">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <p class="font-mono text-sm font-semibold text-amber-200">{{ $order->order_code }}</p>
                    <span class="rounded-full border {{ $order->paymentStatusColor() }} px-2 py-0.5 text-[10px] font-semibold capitalize">
                        {{ $order->payment_status }}
                    </span>
                    <span class="rounded-full border {{ $order->shippingStatusColor() }} px-2 py-0.5 text-[10px] font-semibold">
                        {{ $order->shippingStatusLabel() }}
                    </span>
                </div>
                <p class="mt-1.5 text-xs text-zinc-500">
                    {{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y · H:i') }} WIB
                    · {{ $order->items_count }} item
                    · <span class="capitalize">{{ $order->payment_method }}</span>
                </p>

                {{-- Mini progress bar --}}
                @php
                    $statusOrder = ['menunggu' => 0, 'diproses' => 1, 'dikirim' => 2, 'selesai' => 3];
                    $progress = isset($statusOrder[$order->shipping_status]) ? (($statusOrder[$order->shipping_status] + 1) / 4) * 100 : 0;
                @endphp
                @if($order->shipping_status !== 'dibatalkan')
                <div class="mt-3 flex items-center gap-2">
                    <div class="flex-1 h-1 rounded-full bg-white/10">
                        <div class="h-1 rounded-full bg-gradient-to-r from-amber-500 to-amber-300 transition-all" style="width: {{ $progress }}%"></div>
                    </div>
                    <span class="text-[10px] text-zinc-600 shrink-0">{{ round($progress) }}%</span>
                </div>
                @endif
            </div>

            <div class="flex flex-col items-start gap-3 sm:items-end shrink-0">
                <p class="font-display text-xl font-bold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('pesanan.show', $order) }}" class="rounded-lg border border-white/20 px-3 py-1.5 text-xs font-semibold text-zinc-200 hover:border-amber-500/40 hover:text-amber-200 transition">
                        Detail & Tracking
                    </a>
                    <a href="{{ route('pesanan.struk', $order) }}" class="rounded-lg bg-gradient-to-r from-amber-400 to-amber-600 px-3 py-1.5 text-xs font-bold text-zinc-950 hover:brightness-110 transition">
                        Struk
                    </a>
                </div>
            </div>
        </div>
    </article>
    @empty
    <div class="rounded-2xl border border-dashed border-white/15 bg-white/[0.01] py-20 text-center">
        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full border border-white/10 bg-white/[0.02] text-4xl">📭</div>
        <p class="text-lg font-semibold text-zinc-400">Belum ada pesanan</p>
        <p class="mt-1 text-sm text-zinc-600">Mulai belanja dan pesanan Anda akan muncul di sini</p>
        <a href="{{ route('toko.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-5 py-2.5 text-sm font-bold text-zinc-950 hover:brightness-110 transition">
            🛍️ Mulai Belanja
        </a>
    </div>
    @endforelse
</div>

<div class="mt-8">{{ $orders->links() }}</div>
@endsection
