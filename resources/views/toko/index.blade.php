@extends('layouts.app')

@section('title', $kategori ? $kategori.' — Katalog' : 'Katalog Elektronik')

@section('content')

{{-- Header --}}
<div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/90">
            {{ $kategori ? $kategori : 'Semua Produk' }}
        </p>
        <h1 class="font-display mt-1 text-3xl font-extrabold text-white md:text-4xl">
            {{ $kategori ? $kategori : 'Katalog Elektronik' }}
        </h1>
        <p class="mt-1 text-sm text-zinc-400">{{ $products->total() }} produk ditemukan</p>
    </div>
    {{-- Search --}}
    <form method="get" action="{{ route('toko.index') }}" class="flex w-full max-w-sm gap-2">
        @if($kategori)<input type="hidden" name="kategori" value="{{ $kategori }}">@endif
        @if(request('urut'))<input type="hidden" name="urut" value="{{ request('urut') }}">@endif
        <input name="q" value="{{ request('q') }}" placeholder="Cari produk, kota..."
            class="flex-1 rounded-xl border border-white/10 bg-black/30 px-4 py-2.5 text-sm outline-none focus:border-amber-500/40 focus:ring-2 focus:ring-amber-500/10">
        <button class="rounded-xl bg-amber-500/20 px-4 py-2.5 text-sm font-semibold text-amber-200 hover:bg-amber-500/30 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>
    </form>
</div>

<div class="mt-8 flex gap-8 lg:flex-row flex-col">

    {{-- Sidebar Filter --}}
    <aside class="w-full lg:w-56 shrink-0">
        <form method="get" action="{{ route('toko.index') }}" id="filter-form">
            @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif

            {{-- Kategori --}}
            <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4 mb-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Kategori</p>
                <div class="space-y-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="kategori" value="" {{ !$kategori ? 'checked' : '' }} class="accent-amber-500" onchange="this.form.submit()">
                        <span class="text-sm {{ !$kategori ? 'text-amber-300 font-semibold' : 'text-zinc-400 group-hover:text-white' }}">Semua</span>
                        <span class="ml-auto text-[10px] text-zinc-600">{{ array_sum($kategoryCounts) }}</span>
                    </label>
                    @foreach(\App\Models\Product::CATEGORIES as $cat)
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="kategori" value="{{ $cat }}" {{ $kategori === $cat ? 'checked' : '' }} class="accent-amber-500" onchange="this.form.submit()">
                        <span class="text-sm {{ $kategori === $cat ? 'text-amber-300 font-semibold' : 'text-zinc-400 group-hover:text-white' }}">{{ $cat }}</span>
                        <span class="ml-auto text-[10px] text-zinc-600">{{ $kategoryCounts[$cat] ?? 0 }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Harga --}}
            <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4 mb-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Rentang Harga</p>
                <div class="space-y-2">
                    <div>
                        <label class="text-[10px] text-zinc-600">Min (Rp)</label>
                        <input type="number" name="min_harga" value="{{ request('min_harga') }}" placeholder="0" step="100000"
                            class="mt-1 w-full rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs">
                    </div>
                    <div>
                        <label class="text-[10px] text-zinc-600">Max (Rp)</label>
                        <input type="number" name="max_harga" value="{{ request('max_harga') }}" placeholder="Tidak terbatas" step="100000"
                            class="mt-1 w-full rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs">
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-amber-500/20 py-2 text-xs font-semibold text-amber-200 hover:bg-amber-500/30 transition">Terapkan</button>
                </div>
            </div>

            {{-- Urutkan --}}
            <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Urutkan</p>
                <div class="space-y-1">
                    @foreach(['terbaru' => 'Terbaru', 'diskon' => 'Diskon Terbesar', 'harga_asc' => 'Harga Terendah', 'harga_desc' => 'Harga Tertinggi'] as $val => $label)
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="urut" value="{{ $val }}" {{ $sort === $val ? 'checked' : '' }} class="accent-amber-500" onchange="this.form.submit()">
                        <span class="text-sm {{ $sort === $val ? 'text-amber-300 font-semibold' : 'text-zinc-400 group-hover:text-white' }}">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Reset --}}
            @if(request()->hasAny(['q','kategori','min_harga','max_harga','urut']))
            <a href="{{ route('toko.index') }}" class="mt-3 block text-center text-xs text-rose-400 hover:text-rose-300">✕ Reset filter</a>
            @endif
        </form>
    </aside>

    {{-- Product Grid --}}
    <div class="flex-1">
        {{-- Active filters --}}
        @if(request()->hasAny(['q','kategori','min_harga','max_harga']))
        <div class="mb-4 flex flex-wrap gap-2">
            @if(request('q'))
                <span class="inline-flex items-center gap-1 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs text-amber-300">
                    Cari: "{{ request('q') }}"
                    <a href="{{ request()->fullUrlWithoutQuery(['q']) }}" class="hover:text-white">✕</a>
                </span>
            @endif
            @if($kategori)
                <span class="inline-flex items-center gap-1 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs text-amber-300">
                    {{ $kategori }}
                    <a href="{{ request()->fullUrlWithoutQuery(['kategori']) }}" class="hover:text-white">✕</a>
                </span>
            @endif
            @if(request('min_harga') || request('max_harga'))
                <span class="inline-flex items-center gap-1 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs text-amber-300">
                    Harga: Rp{{ number_format(request('min_harga',0),0,',','.') }} – {{ request('max_harga') ? 'Rp'.number_format(request('max_harga'),0,',','.') : '∞' }}
                    <a href="{{ request()->fullUrlWithoutQuery(['min_harga','max_harga']) }}" class="hover:text-white">✕</a>
                </span>
            @endif
        </div>
        @endif

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse($products as $product)
            <a href="{{ route('toko.show', $product) }}" class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.06] to-transparent p-4 shadow-xl shadow-black/30 transition hover:border-amber-500/30 hover:shadow-amber-500/10">
                <div class="relative aspect-[4/3] w-full overflow-hidden rounded-xl bg-zinc-800/80">
                    @if($product->discount_percent > 0)
                        <span class="absolute right-3 top-3 z-10 rounded-full bg-white px-2.5 py-1 text-[10px] font-bold text-zinc-950 shadow-lg">-{{ $product->discount_percent }}%</span>
                    @endif
                    @if($product->stock <= 3)
                        <span class="absolute left-3 top-3 z-10 rounded-full bg-rose-500/90 px-2 py-0.5 text-[10px] font-bold text-white">Stok {{ $product->stock }}</span>
                    @endif
                    @if($product->displayImageUrl())
                        <img src="{{ $product->displayImageUrl() }}" alt="{{ $product->title }}" class="h-full w-full object-cover opacity-90 transition group-hover:scale-105 group-hover:opacity-100">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-900 text-4xl text-zinc-600">◇</div>
                    @endif
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <span class="rounded-full border border-white/10 px-2 py-0.5 text-[10px] text-zinc-500">{{ $product->category }}</span>
                </div>
                <h2 class="mt-1.5 font-display text-base font-bold text-white group-hover:text-amber-200 line-clamp-1">{{ $product->title }}</h2>
                <p class="mt-1 line-clamp-2 text-xs text-zinc-500">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                <p class="mt-1.5 text-xs text-zinc-600">📍 {{ $product->seller_location }}</p>
                <div class="mt-auto flex items-baseline gap-2 pt-3">
                    @if($product->discount_percent > 0)
                        <span class="text-xs text-zinc-500 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                    <span class="text-base font-bold text-amber-300">Rp{{ number_format($product->effectivePrice(), 0, ',', '.') }}</span>
                </div>
            </a>
            @empty
            <div class="col-span-full py-20 text-center">
                <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full border border-white/10 bg-white/[0.02] text-4xl">🔍</div>
                <p class="text-lg font-semibold text-zinc-400">Produk tidak ditemukan</p>
                <p class="mt-1 text-sm text-zinc-600">Coba ubah filter atau kata kunci pencarian</p>
                <a href="{{ route('toko.index') }}" class="mt-4 inline-block text-sm font-semibold text-amber-400 hover:text-amber-300">Reset semua filter</a>
            </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
    </div>
</div>
@endsection
