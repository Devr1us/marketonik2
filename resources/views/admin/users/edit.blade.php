@extends('layouts.admin')

@section('title', 'Edit Pembeli')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-violet-400 hover:text-violet-300">&larr; Kembali ke detail</a>
    <h1 class="mt-2 font-display text-2xl font-bold text-white">Edit Pembeli</h1>

    <form method="post" action="{{ route('admin.users.update', $user) }}" class="mt-6 space-y-5 rounded-2xl border border-white/10 bg-white/[0.02] p-6">
        @csrf
        @method('PUT')
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Nama</label>
            <input name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Username</label>
            <input name="username" value="{{ old('username', $user->username) }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase text-zinc-500">Password baru</label>
            <input type="password" name="password" placeholder="Kosongkan bila tidak diganti" class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white">
        </div>
        <button class="w-full rounded-xl bg-violet-600 py-3 text-sm font-bold text-white hover:bg-violet-500">Simpan Data</button>
    </form>
</div>
@endsection
