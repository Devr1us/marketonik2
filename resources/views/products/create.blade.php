@extends($layout)

@section('title', $pageTitle ?? 'Jual produk')

@section('content')
@php
    $specifications = old('spec_keys')
        ? collect(old('spec_keys'))->map(fn ($key, $i) => ['key' => $key, 'value' => old('spec_values.'.$i)])->all()
        : collect($product?->specifications ?? ['Merek' => '', 'Model' => '', 'Garansi' => ''])
            ->map(fn ($value, $key) => ['key' => $key, 'value' => $value])
            ->values()
            ->all();
@endphp
<div class="mx-auto max-w-2xl">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-extrabold text-white">{{ $product ? 'Edit produk elektronik' : 'Tambah produk elektronik' }}</h1>
            <p class="mt-2 text-sm text-zinc-400">Unggah foto, isi detail produk, lalu publikasikan ke katalog.</p>
        </div>
        <a href="{{ $backRoute }}" class="text-sm font-semibold text-zinc-500 hover:text-zinc-300">&larr; Kembali</a>
    </div>

    <form class="mt-8 space-y-5 rounded-2xl border border-white/10 bg-zinc-900/40 p-6" method="post" action="{{ $storeRoute }}" enctype="multipart/form-data">
        @csrf
        @if(($method ?? 'POST') !== 'POST')
            @method($method)
        @endif

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Foto produk</label>
            <p class="mt-0.5 text-[11px] text-zinc-600">JPEG, PNG, WebP, atau GIF. Maksimal 5 MB.</p>
            @if($product?->displayImageUrl())
                <div class="mt-3 flex items-center gap-3">
                    <img src="{{ $product->displayImageUrl() }}" alt="{{ $product->title }}" class="h-16 w-16 rounded-xl object-cover">
                    <label class="flex items-center gap-2 text-xs text-zinc-400">
                        <input type="checkbox" name="remove_photo" value="1" class="rounded border-white/10 bg-black/40">
                        Hapus foto saat ini
                    </label>
                </div>
            @endif
            <input type="file" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-2 block w-full text-sm text-zinc-400 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-500/20 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-amber-200 hover:file:bg-amber-500/30">
        </div>

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Judul produk</label>
            <input name="title" value="{{ old('title', $product?->title) }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
        </div>

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Kategori</label>
            <select name="category" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
                @foreach($categories ?? \App\Models\Product::CATEGORIES as $category)
                    <option value="{{ $category }}" @selected(old('category', $product?->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Deskripsi</label>
            <textarea name="description" rows="4" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">{{ old('description', $product?->description) }}</textarea>
        </div>

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Lokasi penjual</label>
            <input name="seller_location" value="{{ old('seller_location', $product?->seller_location) }}" required placeholder="Kota / kecamatan / titik COD" class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product?->price) }}" min="0" step="1000" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Diskon %</label>
                <input type="number" name="discount_percent" value="{{ old('discount_percent', $product?->discount_percent ?? 0) }}" min="0" max="90" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $product?->stock ?? 1) }}" min="0" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Spesifikasi</label>
            <div id="spec-rows" class="mt-2 space-y-2">
                @foreach($specifications as $spec)
                    <div class="flex gap-2">
                        <input name="spec_keys[]" value="{{ $spec['key'] }}" placeholder="Nama field" class="flex-1 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs">
                        <input name="spec_values[]" value="{{ $spec['value'] }}" placeholder="Nilai" class="flex-1 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs">
                    </div>
                @endforeach
            </div>
            <button type="button" class="mt-2 text-xs font-semibold text-amber-400 hover:text-amber-300" onclick="addRow()">+ baris spesifikasi</button>
        </div>

        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-sm font-bold text-zinc-950 hover:brightness-110">
            {{ $product ? 'Simpan Perubahan' : 'Publikasikan' }}
        </button>
    </form>
</div>

<script>
function addRow() {
    const wrap = document.getElementById('spec-rows');
    const d = document.createElement('div');
    d.className = 'flex gap-2';
    d.innerHTML = '<input name="spec_keys[]" class="flex-1 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs" placeholder="Nama field"><input name="spec_values[]" class="flex-1 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs" placeholder="Nilai">';
    wrap.appendChild(d);
}
</script>
@endsection
