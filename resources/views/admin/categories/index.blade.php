@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Katalog</p>
        <h1 class="font-display text-2xl font-bold text-white">Kategori Produk</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ $categories->total() }} kategori terdaftar</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.kategori.create') }}" class="rounded-xl bg-violet-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-violet-500">+ Tambah Kategori</a>
        <form method="get" class="flex gap-2">
            <input name="q" value="{{ $q }}" placeholder="Cari kategori" class="rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300 outline-none">
            <button class="rounded-xl border border-white/15 px-4 py-2 text-xs font-semibold text-zinc-300">Cari</button>
        </form>
    </div>
</div>

<div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    @forelse($categories as $category)
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="font-display text-lg font-bold text-white">{{ $category->name }}</h2>
                    <p class="mt-1 text-xs text-zinc-500">{{ $category->products_count }} produk aktif</p>
                </div>
                <span class="rounded-full border px-2.5 py-0.5 text-[10px] font-semibold {{ $category->is_active ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300' : 'border-zinc-600 text-zinc-500' }}">
                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <p class="mt-3 min-h-10 text-sm text-zinc-400">{{ $category->description ?: 'Belum ada deskripsi.' }}</p>
            <div class="mt-5 flex gap-2">
                <a href="{{ route('admin.kategori.edit', $category) }}" class="rounded-lg border border-white/15 px-3 py-1.5 text-xs font-semibold text-zinc-300 hover:border-violet-500/40">Edit</a>
                <form method="post" action="{{ route('admin.kategori.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg border border-rose-500/20 px-3 py-1.5 text-xs font-semibold text-rose-400 hover:bg-rose-500/10">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="rounded-2xl border border-white/10 p-8 text-center text-zinc-500 md:col-span-2 xl:col-span-3">Belum ada kategori.</div>
    @endforelse
</div>

<div class="mt-6">{{ $categories->links() }}</div>
@endsection
