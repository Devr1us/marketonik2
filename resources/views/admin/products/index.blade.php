@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="font-display text-2xl font-bold text-white">Produk</h1>
        <p class="text-sm text-zinc-500">Kelola katalog toko.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-violet-600 px-4 py-2 text-xs font-bold text-white hover:brightness-110">+ Jual produk</a>
        <form method="get" class="flex gap-2">
            <input name="q" value="{{ $q }}" placeholder="Cari produk…" class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-sm">
            <button class="rounded-lg border border-white/15 px-4 py-2 text-xs font-semibold text-zinc-300">Cari</button>
        </form>
    </div>
</div>

<div class="mt-8 space-y-3">
    @forelse($products as $product)
        <article class="flex flex-col gap-3 rounded-xl border border-white/10 bg-white/[0.02] p-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-semibold text-white">{{ $product->title }}</p>
                <p class="text-xs text-zinc-500">{{ $product->seller?->name }} · Stok {{ $product->stock }}</p>
                <p class="mt-1 text-sm text-amber-200">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <form method="post" action="{{ route('admin.products.toggle', $product) }}">
                    @csrf
                    @method('PATCH')
                    <button class="rounded-lg border px-3 py-1.5 text-xs {{ $product->is_active ? 'border-emerald-500/40 text-emerald-300' : 'border-zinc-600 text-zinc-500' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </form>
                <form method="post" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg border border-rose-500/30 px-3 py-1.5 text-xs text-rose-300">Hapus</button>
                </form>
            </div>
        </article>
    @empty
        <p class="text-center text-zinc-500 py-12">Belum ada produk.</p>
    @endforelse
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
