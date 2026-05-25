@extends('layouts.app')

@section('title', 'Struk '.$order->order_code)

@section('content')
<div class="mx-auto max-w-lg rounded-2xl border border-white/10 bg-white text-zinc-900 p-8 shadow-2xl print:border-0 print:shadow-none print:p-0">
    <div class="text-center">
        <p class="font-display text-2xl font-extrabold">Marketonik</p>
        <p class="text-xs text-zinc-500">Struk pembayaran / pesanan</p>
    </div>
    <hr class="my-6 border-zinc-200">
    <div class="space-y-1 text-sm">
        <div class="flex justify-between"><span class="text-zinc-500">Kode</span><span class="font-mono font-semibold">{{ $order->order_code }}</span></div>
        <div class="flex justify-between"><span class="text-zinc-500">Tanggal</span><span>{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span></div>
        <div class="flex justify-between"><span class="text-zinc-500">Pelanggan</span><span>{{ $order->user->name }}</span></div>
        <div class="flex justify-between"><span class="text-zinc-500">Metode</span><span class="capitalize">{{ $order->payment_method }}</span></div>
        <div class="flex justify-between"><span class="text-zinc-500">Status</span><span class="font-semibold">{{ $order->payment_status }}</span></div>
    </div>
    <hr class="my-6 border-zinc-200">
    <ul class="space-y-3 text-sm">
        @foreach($order->items as $line)
            <li>
                <div class="flex justify-between gap-2 font-medium">
                    <span>{{ $line->product_title }} × {{ $line->quantity }}</span>
                    <span>Rp{{ number_format($line->line_total, 0, ',', '.') }}</span>
                </div>
                @if($line->discount_percent > 0)
                    <p class="text-xs text-emerald-600">Diskon item {{ $line->discount_percent }}% terhitung dalam harga satuan.</p>
                @endif
            </li>
        @endforeach
    </ul>
    <hr class="my-6 border-zinc-200">
    <div class="space-y-1 text-sm">
        <div class="flex justify-between text-zinc-600"><span>Subtotal</span><span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
        <div class="flex justify-between text-emerald-700"><span>Total diskon</span><span>− Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span></div>
        <div class="flex justify-between text-lg font-extrabold"><span>Total bayar</span><span>Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>
    </div>
    <p class="mt-6 rounded-lg bg-zinc-100 p-3 text-xs text-zinc-600">{{ $order->payment_note }}</p>
    <div class="mt-8 flex flex-wrap gap-3 print:hidden">
        <button type="button" onclick="window.print()" class="min-w-[8rem] flex-1 rounded-xl bg-zinc-900 py-3 text-sm font-bold text-white hover:bg-zinc-800">Cetak struk</button>
        <a href="{{ route('pesanan.index') }}" class="min-w-[8rem] flex-1 rounded-xl border border-zinc-300 py-3 text-center text-sm font-semibold text-zinc-800 hover:bg-zinc-50">Riwayat pesanan</a>
        <a href="{{ route('toko.index') }}" class="min-w-[8rem] flex-1 rounded-xl border border-zinc-300 py-3 text-center text-sm font-semibold text-zinc-800 hover:bg-zinc-50">Lanjut belanja</a>
    </div>
</div>

<style media="print">
    body { background: white !important; }
    header, footer, .print\:hidden { display: none !important; }
</style>
@endsection
