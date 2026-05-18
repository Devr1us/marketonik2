@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div>
    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-400">Ringkasan</p>
    <h1 class="font-display mt-2 text-3xl font-extrabold text-white">Dashboard Admin</h1>
</div>

<div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
    @foreach([
        ['label' => 'Pembeli', 'value' => $stats['users'], 'color' => 'text-sky-300'],
        ['label' => 'Produk', 'value' => $stats['products'], 'color' => 'text-amber-300'],
        ['label' => 'Pesanan', 'value' => $stats['orders'], 'color' => 'text-emerald-300'],
        ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'text-rose-300'],
        ['label' => 'Omzet', 'value' => 'Rp'.number_format($stats['revenue'], 0, ',', '.'), 'color' => 'text-violet-300'],
    ] as $card)
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-5">
            <p class="text-xs text-zinc-500">{{ $card['label'] }}</p>
            <p class="font-display mt-2 text-2xl font-bold {{ $card['color'] }}">{{ $card['value'] }}</p>
        </div>
    @endforeach
</div>

<section class="mt-10">
    <h2 class="font-display text-lg font-bold text-white">Pesanan terbaru</h2>
    <div class="mt-4 overflow-hidden rounded-2xl border border-white/10">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-xs uppercase text-zinc-500">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Pembeli</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 font-mono text-amber-200">{{ $order->order_code }}</td>
                        <td class="px-4 py-3">{{ $order->user->name }}</td>
                        <td class="px-4 py-3">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 capitalize">{{ $order->payment_status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-zinc-500">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
