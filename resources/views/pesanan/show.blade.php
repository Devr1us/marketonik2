@extends('layouts.app')

@section('title', 'Pesanan '.$order->order_code)

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6 flex items-center gap-2 text-xs text-zinc-500">
    <a href="{{ route('pembeli.dashboard') }}" class="hover:text-amber-300">Beranda</a>
    <span>›</span>
    <a href="{{ route('pesanan.index') }}" class="hover:text-amber-300">Pesanan Saya</a>
    <span>›</span>
    <span class="text-zinc-400">{{ $order->order_code }}</span>
</nav>

<div class="flex flex-wrap items-start justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-2xl font-extrabold text-white md:text-3xl">{{ $order->order_code }}</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y · H:i') }} WIB</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <span class="rounded-full border {{ $order->paymentStatusColor() }} px-3 py-1 text-xs font-semibold capitalize">
            💳 {{ $order->payment_status }}
        </span>
        <span class="rounded-full border {{ $order->shippingStatusColor() }} px-3 py-1 text-xs font-semibold">
            🚚 {{ $order->shippingStatusLabel() }}
        </span>
    </div>
</div>

{{-- Shipping Timeline --}}
<div class="mb-8 rounded-2xl border border-white/10 bg-white/[0.02] p-6">
    <h2 class="font-display text-base font-bold text-white mb-5">Status Pengiriman</h2>
    @php
        $steps = [
            ['key' => 'menunggu',   'label' => 'Pesanan Diterima',    'icon' => '📋', 'desc' => 'Pesanan Anda telah masuk ke sistem'],
            ['key' => 'diproses',   'label' => 'Sedang Diproses',     'icon' => '⚙️', 'desc' => 'Penjual sedang mempersiapkan barang'],
            ['key' => 'dikirim',    'label' => 'Dalam Pengiriman',    'icon' => '🚚', 'desc' => 'Barang sedang dalam perjalanan'],
            ['key' => 'selesai',    'label' => 'Pesanan Selesai',     'icon' => '✅', 'desc' => 'Barang telah diterima'],
        ];
        $statusOrder = ['menunggu' => 0, 'diproses' => 1, 'dikirim' => 2, 'selesai' => 3, 'dibatalkan' => -1];
        $currentStep = $statusOrder[$order->shipping_status] ?? 0;
        $isCancelled = $order->shipping_status === 'dibatalkan';
    @endphp

    @if($isCancelled)
    <div class="flex items-center gap-3 rounded-xl border border-rose-500/30 bg-rose-500/10 p-4">
        <span class="text-2xl">❌</span>
        <div>
            <p class="text-sm font-semibold text-rose-300">Pesanan Dibatalkan</p>
            <p class="text-xs text-rose-400/70">Pesanan ini telah dibatalkan</p>
        </div>
    </div>
    @else
    <div class="flex items-start gap-0">
        @foreach($steps as $i => $step)
        @php $done = $currentStep >= $i; $active = $currentStep === $i; @endphp
        <div class="flex flex-1 flex-col items-center">
            <div class="flex items-center w-full">
                @if($i > 0)
                <div class="flex-1 h-0.5 {{ $currentStep >= $i ? 'bg-amber-500' : 'bg-white/10' }} transition-all"></div>
                @endif
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 {{ $active ? 'border-amber-400 bg-amber-500/20 ring-4 ring-amber-500/20' : ($done ? 'border-amber-500 bg-amber-500/10' : 'border-white/15 bg-white/[0.02]') }} transition-all text-lg">
                    {{ $step['icon'] }}
                </div>
                @if($i < count($steps) - 1)
                <div class="flex-1 h-0.5 {{ $currentStep > $i ? 'bg-amber-500' : 'bg-white/10' }} transition-all"></div>
                @endif
            </div>
            <div class="mt-2 text-center px-1">
                <p class="text-[10px] font-semibold {{ $active ? 'text-amber-300' : ($done ? 'text-zinc-300' : 'text-zinc-600') }}">{{ $step['label'] }}</p>
                @if($active)
                <p class="text-[9px] text-zinc-500 mt-0.5 hidden sm:block">{{ $step['desc'] }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($order->tracking_number)
    <div class="mt-5 flex items-center gap-3 rounded-xl border border-white/10 bg-black/20 p-3">
        <span class="text-lg">📦</span>
        <div>
            <p class="text-xs text-zinc-500">Nomor Resi</p>
            <p class="font-mono text-sm font-bold text-amber-200">{{ $order->tracking_number }}</p>
        </div>
    </div>
    @endif

    @if($order->shipping_address)
    <div class="mt-3 flex items-center gap-3 rounded-xl border border-white/10 bg-black/20 p-3">
        <span class="text-lg">📍</span>
        <div>
            <p class="text-xs text-zinc-500">Alamat Pengiriman</p>
            <p class="text-sm text-zinc-300">{{ $order->shipping_address }}</p>
        </div>
    </div>
    @endif
</div>

<div class="grid gap-6 lg:grid-cols-2">
    {{-- Items --}}
    <div class="rounded-2xl border border-white/10 bg-zinc-900/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-white/10">
            <h2 class="font-display text-base font-bold text-white">Item Pesanan</h2>
        </div>
        <ul class="divide-y divide-white/5">
            @foreach($order->items as $line)
            <li class="flex items-center gap-3 px-5 py-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-zinc-200 line-clamp-1">{{ $line->product_title }}</p>
                    @if($line->discount_percent > 0)
                        <p class="text-[10px] text-amber-400">Diskon {{ $line->discount_percent }}%</p>
                    @endif
                </div>
                <span class="text-xs text-zinc-500 shrink-0">× {{ $line->quantity }}</span>
                <span class="text-sm font-semibold text-amber-200 shrink-0">Rp{{ number_format($line->line_total, 0, ',', '.') }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Payment summary --}}
    <div class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-6">
        <h2 class="font-display text-base font-bold text-white mb-4">Ringkasan Pembayaran</h2>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between text-zinc-400">
                <dt>Subtotal katalog</dt>
                <dd>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</dd>
            </div>
            @if($order->discount_amount > 0)
            <div class="flex justify-between text-emerald-400">
                <dt>Total diskon</dt>
                <dd>− Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</dd>
            </div>
            @endif
            <div class="flex justify-between border-t border-white/10 pt-3 text-lg font-bold text-white">
                <dt>Total Bayar</dt>
                <dd>Rp{{ number_format($order->total, 0, ',', '.') }}</dd>
            </div>
        </dl>

        <div class="mt-4 rounded-xl border border-white/10 bg-black/20 p-3">
            <p class="text-xs text-zinc-500">Metode: <span class="text-zinc-300 capitalize">{{ $order->payment_method }}</span></p>
            @if($order->payment_note)
            <p class="mt-1 text-xs text-zinc-500">{{ $order->payment_note }}</p>
            @endif
            @if($order->paymentProofUrl())
            <a href="{{ $order->paymentProofUrl() }}" target="_blank" class="mt-3 inline-flex rounded-lg border border-amber-500/30 px-3 py-1.5 text-xs font-semibold text-amber-200 hover:bg-amber-500/10">
                Lihat Bukti Pembayaran
            </a>
            @endif
        </div>

        <div class="mt-5 flex flex-col gap-2">
            <a href="{{ route('pesanan.struk', $order) }}" class="block rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-center text-sm font-bold text-zinc-950 hover:brightness-110 transition">
                🧾 Cetak Struk
            </a>
            <a href="{{ route('pesanan.index') }}" class="block rounded-xl border border-white/15 py-3 text-center text-sm font-semibold text-zinc-300 hover:border-amber-500/40 hover:text-amber-200 transition">
                ← Kembali ke Riwayat
            </a>
        </div>
    </div>
</div>

@endsection
