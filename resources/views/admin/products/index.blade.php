@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Manajemen</p>
        <h1 class="font-display text-2xl font-bold text-white">Daftar Produk</h1>
        <p class="text-sm text-zinc-500 mt-1">{{ $products->total() }} produk ditemukan</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.products.create') }}" class="rounded-xl bg-violet-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-violet-500 transition">
            + Tambah Produk
        </a>
        <form method="get" class="flex gap-2">
            <input name="q" value="{{ $q }}" placeholder="Cari produk…"
                class="rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300 focus:border-violet-500/40 outline-none">
            <button class="rounded-xl border border-white/15 px-4 py-2 text-xs font-semibold text-zinc-300 hover:border-violet-500/40 transition">Cari</button>
        </form>
    </div>
</div>

<div class="mt-6 overflow-hidden rounded-2xl border border-white/10">
    <table class="w-full text-left text-sm">
        <thead class="bg-white/[0.03] text-xs uppercase text-zinc-500">
            <tr>
                <th class="px-5 py-3">Produk</th>
                <th class="px-5 py-3 hidden sm:table-cell">Kategori</th>
                <th class="px-5 py-3 hidden md:table-cell">Penjual</th>
                <th class="px-5 py-3">Harga</th>
                <th class="px-5 py-3 hidden lg:table-cell">Stok</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($products as $product)
            <tr class="hover:bg-white/[0.02] transition">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-lg bg-zinc-800">
                            @if($product->displayImageUrl())
                                <img src="{{ $product->displayImageUrl() }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-lg text-zinc-600">◇</div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate max-w-[180px]">{{ $product->title }}</p>
                            @if($product->discount_percent > 0)
                                <span class="text-[10px] text-amber-400">-{{ $product->discount_percent }}% diskon</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <span class="rounded-full border border-white/10 px-2 py-0.5 text-[10px] text-zinc-400">{{ $product->category }}</span>
                </td>
                <td class="px-5 py-3 hidden md:table-cell text-xs text-zinc-400">{{ $product->seller?->name }}</td>
                <td class="px-5 py-3 text-xs font-semibold text-amber-200">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</td>
                <td class="px-5 py-3 hidden lg:table-cell">
                    <span class="text-xs {{ $product->stock <= 3 ? 'text-rose-400' : ($product->stock <= 10 ? 'text-yellow-400' : 'text-emerald-400') }}">
                        {{ $product->stock }} unit
                    </span>
                </td>
                <td class="px-5 py-3">
                    <form method="post" action="{{ route('admin.products.toggle', $product) }}">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-full border px-2.5 py-0.5 text-[10px] font-semibold transition {{ $product->is_active ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20' : 'border-zinc-600 text-zinc-500 hover:border-zinc-500' }}">
                            {{ $product->is_active ? '● Aktif' : '○ Nonaktif' }}
                        </button>
                    </form>
                </td>
                <td class="px-5 py-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-white/15 px-2.5 py-1 text-[10px] text-zinc-300 hover:border-violet-500/40 transition">Edit</a>
                        <form method="post" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-rose-500/20 px-2.5 py-1 text-[10px] text-rose-400 hover:bg-rose-500/10 transition">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-16 text-center">
                    <p class="text-4xl mb-3">📦</p>
                    <p class="text-zinc-500">Belum ada produk.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
