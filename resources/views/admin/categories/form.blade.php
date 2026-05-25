@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('admin.kategori.index') }}" class="text-xs text-violet-400 hover:text-violet-300">&larr; Kembali ke kategori</a>
    <h1 class="mt-2 font-display text-2xl font-bold text-white">{{ $title }}</h1>

    <form method="post" action="{{ $action }}" class="mt-6 space-y-5 rounded-2xl border border-white/10 bg-white/[0.02] p-6">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Nama kategori</label>
            <input name="name" value="{{ old('name', $category->name) }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Deskripsi</label>
            <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white">{{ old('description', $category->description) }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm text-zinc-300">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active)) class="rounded border-white/10 bg-black/40">
            Tampilkan kategori di form produk
        </label>
        <button class="w-full rounded-xl bg-violet-600 py-3 text-sm font-bold text-white hover:bg-violet-500">Simpan Kategori</button>
    </form>
</div>
@endsection
