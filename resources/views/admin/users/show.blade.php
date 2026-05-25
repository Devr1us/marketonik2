@extends('layouts.admin')

@section('title', $user->name)

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-3">
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-violet-400 hover:text-violet-300">&larr; Kembali ke pembeli</a>
        <h1 class="mt-2 font-display text-2xl font-bold text-white">{{ $user->name }}</h1>
        <p class="text-sm text-zinc-500">@{{ $user->username }} · {{ $user->email ?: 'Email belum diisi' }}</p>
    </div>
    <a href="{{ route('admin.users.edit', $user) }}" class="rounded-xl bg-violet-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-violet-500">Edit Pembeli</a>
</div>

<div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Pesanan</p>
        <p class="mt-2 text-2xl font-bold text-white">{{ $user->orders_count }}</p>
    </div>
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Keranjang</p>
        <p class="mt-2 text-2xl font-bold text-white">{{ $user->cart_items_count }}</p>
    </div>
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <p class="text-xs uppercase text-zinc-500">Produk Dijual</p>
        <p class="mt-2 text-2xl font-bold text-white">{{ $user->products_count }}</p>
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <h2 class="font-display text-lg font-bold text-white">Pesanan Terbaru</h2>
        <div class="mt-4 space-y-3">
            @forelse($orders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="block rounded-xl border border-white/10 p-3 hover:border-violet-500/40">
                    <div class="flex justify-between gap-3">
                        <span class="font-mono text-xs text-amber-200">{{ $order->order_code }}</span>
                        <span class="text-xs font-semibold text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <p class="mt-1 text-[10px] text-zinc-500">{{ $order->items_count }} item · {{ $order->created_at->format('d M Y') }}</p>
                </a>
            @empty
                <p class="text-sm text-zinc-500">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
        <h2 class="font-display text-lg font-bold text-white">Produk Pembeli</h2>
        <div class="mt-4 space-y-3">
            @forelse($products as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="block rounded-xl border border-white/10 p-3 hover:border-violet-500/40">
                    <div class="flex justify-between gap-3">
                        <span class="text-sm font-semibold text-white">{{ $product->title }}</span>
                        <span class="text-xs text-amber-200">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</span>
                    </div>
                    <p class="mt-1 text-[10px] text-zinc-500">{{ $product->category }} · stok {{ $product->stock }}</p>
                </a>
            @empty
                <p class="text-sm text-zinc-500">Belum menjual produk.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
