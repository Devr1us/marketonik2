@extends('layouts.app')

@section('title', 'Admin — Masuk')

@section('content')
<div class="mx-auto max-w-md py-12">
    <div class="text-center mb-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Panel Admin</p>
        <h1 class="font-display mt-2 text-3xl font-extrabold text-white">Masuk Admin</h1>
        <p class="mt-2 text-sm text-zinc-500">Gunakan akun admin yang terdaftar di database MySQL.</p>
    </div>

    <div class="rounded-2xl border border-violet-500/20 bg-zinc-900/50 p-6 shadow-xl">
        <form method="post" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Username admin</label>
                <input name="username" value="{{ old('username', 'admin') }}" required
                    class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none focus:border-violet-500/50 focus:ring-4 focus:ring-violet-500/15">
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Password</label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm outline-none focus:border-violet-500/50 focus:ring-4 focus:ring-violet-500/15">
            </div>
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-600 py-3 text-sm font-bold text-white shadow-lg hover:brightness-110">
                Masuk dashboard admin
            </button>
        </form>
        <p class="mt-6 text-center text-xs text-zinc-600">
            Pembeli? <a href="{{ route('gate') }}" class="text-amber-400 hover:text-amber-300">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
