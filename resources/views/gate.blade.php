@extends('layouts.app')

@section('title', 'Masuk — Marketonik')

@section('content')
<div class="mx-auto max-w-lg py-6 md:py-16">
    <div class="mb-10 text-center">
        <div class="mx-auto mb-6 flex justify-center">
            <span class="inline-flex items-center justify-center overflow-hidden rounded-2xl bg-zinc-200 p-3 shadow-lg shadow-black/30 ring-1 ring-white/10">
                <img src="{{ asset('images/marketonik-logo.png') }}" alt="Marketonik" width="96" height="96" class="h-20 w-20 object-contain md:h-24 md:w-24" loading="eager" decoding="async">
            </span>
        </div>
        <p class="font-display text-4xl font-extrabold tracking-tight text-white md:text-5xl">Marketonik</p>
        <p class="mt-3 text-sm text-zinc-400">Gerbang elektronik premium. Masuk atau daftar untuk melanjutkan.</p>

    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <button type="button" id="tab-daftar" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-left transition hover:border-amber-500/40 hover:bg-white/[0.07]">
            <p class="font-display text-lg font-bold text-white">Daftar</p>
            <p class="text-xs text-zinc-500">Belum punya akun demo</p>
        </button>
        <button type="button" id="tab-masuk" class="rounded-2xl border border-amber-500/30 bg-amber-500/10 px-4 py-4 text-left ring-1 ring-amber-500/20">
            <p class="font-display text-lg font-bold text-amber-100">Masuk</p>
            <p class="text-xs text-amber-200/70">Sudah punya username</p>
        </button>
    </div>

    <div id="panel-daftar" class="mt-8 hidden rounded-2xl border border-white/10 bg-zinc-900/40 p-6 shadow-2xl shadow-black/40 backdrop-blur">
        <h2 class="font-display text-xl font-bold text-white">Buat akun</h2>
        <p class="mt-1 text-xs text-zinc-500">Daftar sebagai pembeli. Password minimal 6 karakter.</p>
        <form class="mt-6 space-y-4" method="post" action="{{ route('auth.register') }}">
            @csrf
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Nama tampilan</label>
                <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none ring-amber-500/0 focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/15" placeholder="Contoh: Raka Pratama">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Username</label>
                <input name="username" value="{{ old('username') }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/15" placeholder="tanpa spasi">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Password</label>
                <input type="password" name="password" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/15" placeholder="apa saja">
            </div>
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 py-3 text-sm font-bold text-zinc-950 shadow-lg shadow-amber-500/25 hover:brightness-110">Daftar & masuk dashboard</button>
        </form>
    </div>

    <div id="panel-masuk" class="mt-8 rounded-2xl border border-white/10 bg-zinc-900/40 p-6 shadow-2xl shadow-black/40 backdrop-blur">
        <h2 class="font-display text-xl font-bold text-white">Masuk</h2>
        <p class="mt-1 text-xs text-zinc-500">Masuk dengan username dan password pembeli Anda.</p>
        <form class="mt-6 space-y-4" method="post" action="{{ route('auth.login') }}">
            @csrf
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Username</label>
                <input name="username" value="{{ old('username') }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/15" placeholder="username Anda">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Password</label>
                <input type="password" name="password" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/15" placeholder="isi bebas">
            </div>
            <button type="submit" class="w-full rounded-xl border border-amber-500/40 bg-amber-500/10 py-3 text-sm font-bold text-amber-100 hover:bg-amber-500/20">Masuk dashboard pembeli</button>
        </form>
    </div>

    <p class="mt-8 text-center text-xs text-zinc-600">
        Admin? <a href="{{ route('admin.login') }}" class="text-violet-400 hover:text-violet-300">Masuk panel admin</a>
    </p>
</div>

<script>
document.getElementById('tab-daftar').addEventListener('click', () => {
    document.getElementById('panel-daftar').classList.remove('hidden');
    document.getElementById('panel-masuk').classList.add('hidden');
});
document.getElementById('tab-masuk').addEventListener('click', () => {
    document.getElementById('panel-masuk').classList.remove('hidden');
    document.getElementById('panel-daftar').classList.add('hidden');
});
</script>
@endsection
