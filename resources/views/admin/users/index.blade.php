@extends('layouts.admin')

@section('title', 'Pembeli')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="font-display text-2xl font-bold text-white">Data Pembeli</h1>
        <p class="text-sm text-zinc-500">Akun pembeli terdaftar di MySQL.</p>
    </div>
    <form method="get" class="flex gap-2">
        <input name="q" value="{{ $q }}" placeholder="Cari nama / username…" class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-sm outline-none focus:border-violet-500/50">
        <button class="rounded-lg bg-violet-600 px-4 py-2 text-xs font-bold text-white">Cari</button>
    </form>
</div>

<div class="mt-8 overflow-hidden rounded-2xl border border-white/10">
    <table class="w-full text-left text-sm">
        <thead class="bg-white/5 text-xs uppercase text-zinc-500">
            <tr>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Username</th>
                <th class="px-4 py-3">Pesanan</th>
                <th class="px-4 py-3">Keranjang</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($users as $user)
                <tr>
                    <td class="px-4 py-3 font-medium text-white">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-zinc-400">{{ $user->username }}</td>
                    <td class="px-4 py-3">{{ $user->orders_count }}</td>
                    <td class="px-4 py-3">{{ $user->cart_items_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-violet-300 hover:text-violet-200">Detail</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-zinc-300 hover:text-white">Edit</a>
                            <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pembeli ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-rose-400 hover:text-rose-300">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-zinc-500">Tidak ada pembeli.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $users->links() }}</div>
@endsection
