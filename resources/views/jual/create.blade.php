@extends('layouts.app')

@section('title', 'Jual produk')

@section('content')
<div class="mx-auto max-w-2xl">
    <h1 class="font-display text-3xl font-extrabold text-white">Tambah produk elektronik</h1>
    <p class="mt-2 text-sm text-zinc-400">Deskripsi, lokasi Anda, dan spesifikasi teknis membantu pembeli percaya.</p>

    <form class="mt-8 space-y-5 rounded-2xl border border-white/10 bg-zinc-900/40 p-6" method="post" action="{{ route('jual.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Foto produk</label>
            <p class="mt-0.5 text-[11px] text-zinc-600">JPEG, PNG, WebP, atau GIF — maks. 5 MB. Opsional; tanpa foto akan memakai placeholder di katalog.</p>
            <input type="file" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-2 block w-full text-sm text-zinc-400 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-500/20 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-amber-200 hover:file:bg-amber-500/30">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Judul produk</label>
            <input name="title" value="{{ old('title') }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Deskripsi</label>
            <textarea name="description" rows="4" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Lokasi penjual</label>
            <input name="seller_location" value="{{ old('seller_location') }}" required placeholder="Kota / kecamatan / titik COD" class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
        </div>
        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" step="1000" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Diskon %</label>
                <input type="number" name="discount_percent" value="{{ old('discount_percent', 0) }}" min="0" max="90" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase text-zinc-500">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Spesifikasi (pasangan kunci / nilai)</label>
            <div id="spec-rows" class="mt-2 space-y-2">
                @foreach(old('spec_keys', ['Merek','Model','Garansi']) as $i => $k)
                    <div class="flex gap-2">
                        <input name="spec_keys[]" value="{{ old('spec_keys.'.$i, $k) }}" placeholder="Nama field" class="flex-1 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs">
                        <input name="spec_values[]" value="{{ old('spec_values.'.$i) }}" placeholder="Nilai" class="flex-1 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-xs">
                    </div>
                @endforeach
            </div>
            <button type="button" class="mt-2 text-xs font-semibold text-amber-400 hover:text-amber-300" onclick="addRow()">+ baris spesifikasi</button>
        </div>

        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-sm font-bold text-zinc-950">Publikasikan</button>
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
