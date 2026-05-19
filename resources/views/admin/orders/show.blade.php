@extends('layouts.admin')

@section('title', $order->order_code)

@section('content')
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-violet-400 hover:text-violet-300">← Kembali ke daftar pesanan</a>
        <h1 class="font-display mt-2 text-2xl font-bold text-white">{{ $order->order_code }}</h1>
        <p class="text-sm text-zinc-500">
            {{ $order->user->name }} (@{{ $order->user->username }}) ·
            {{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
        </p>
    </div>
    <div class="flex gap-2 flex-wrap">
        <span class="rounded-full border {{ $order->paymentStatusColor() }} px-3 py-1 text-xs font-semibold capitalize">
            💳 {{ $order->payment_status }}
        </span>
        <span class="rounded-full border {{ $order->shippingStatusColor() }} px-3 py-1 text-xs font-semibold">
            🚚 {{ $order->shippingStatusLabel() }}
        </span>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">

    {{-- Order Items --}}
    <div class="lg:col-span-2 space-y-4">
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10">
                <h2 class="font-display text-base font-bold text-white">Item Pesanan</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-white/[0.02] text-xs uppercase text-zinc-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Produk</th>
                        <th class="px-5 py-3 text-center">Qty</th>
                        <th class="px-5 py-3 text-right">Harga Satuan</th>
                        <th class="px-5 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-5 py-3">
                            <p class="text-zinc-200 font-medium">{{ $item->product_title }}</p>
                            @if($item->discount_percent > 0)
                                <p class="text-[10px] text-amber-400">Diskon {{ $item->discount_percent }}%</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center text-zinc-400">{{ $item->quantity }}</td>
                        <td class="px-5 py-3 text-right text-zinc-300">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-right font-semibold text-amber-200">Rp{{ number_format($item->line_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-5 py-4 border-t border-white/10 space-y-2">
                <div class="flex justify-between text-sm text-zinc-400">
                    <span>Subtotal katalog</span>
                    <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-sm text-emerald-400">
                    <span>Total diskon</span>
                    <span>− Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold text-white border-t border-white/10 pt-2">
                    <span>Total Bayar</span>
                    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Payment note --}}
        @if($order->payment_note)
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-2">Catatan Pembayaran</h3>
            <p class="text-sm text-zinc-400">{{ $order->payment_note }}</p>
        </div>
        @endif

        {{-- Shipping info --}}
        @if($order->shipping_address || $order->tracking_number)
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Info Pengiriman</h3>
            @if($order->shipping_address)
            <div class="mb-2">
                <p class="text-[10px] text-zinc-600">Alamat</p>
                <p class="text-sm text-zinc-300">{{ $order->shipping_address }}</p>
            </div>
            @endif
            @if($order->tracking_number)
            <div>
                <p class="text-[10px] text-zinc-600">No. Resi</p>
                <p class="text-sm font-mono text-amber-200">{{ $order->tracking_number }}</p>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Update Status --}}
    <div class="space-y-4">
        {{-- Payment status --}}
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <h2 class="font-display text-base font-bold text-white mb-4">Update Status Pembayaran</h2>
            <form method="post" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                @csrf
                @method('PATCH')
                <select name="payment_status" class="w-full rounded-xl border border-white/10 bg-black/40 px-3 py-2.5 text-sm text-zinc-300">
                    <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                    <option value="menunggu" @selected($order->payment_status === 'menunggu')>Menunggu</option>
                    <option value="lunas" @selected($order->payment_status === 'lunas')>Lunas</option>
                    <option value="cancelled" @selected($order->payment_status === 'cancelled')>Cancelled</option>
                </select>
                <button class="w-full rounded-xl bg-violet-600 py-2.5 text-sm font-bold text-white hover:bg-violet-500 transition">
                    Simpan Status Pembayaran
                </button>
            </form>
        </div>

        {{-- Shipping status --}}
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <h2 class="font-display text-base font-bold text-white mb-4">Update Status Pengiriman</h2>
            <form method="post" action="{{ route('admin.orders.shipping', $order) }}" class="space-y-3">
                @csrf
                @method('PATCH')
                <select name="shipping_status" class="w-full rounded-xl border border-white/10 bg-black/40 px-3 py-2.5 text-sm text-zinc-300">
                    <option value="menunggu" @selected($order->shipping_status === 'menunggu')>Menunggu Konfirmasi</option>
                    <option value="diproses" @selected($order->shipping_status === 'diproses')>Sedang Diproses</option>
                    <option value="dikirim" @selected($order->shipping_status === 'dikirim')>Dalam Pengiriman</option>
                    <option value="selesai" @selected($order->shipping_status === 'selesai')>Selesai</option>
                    <option value="dibatalkan" @selected($order->shipping_status === 'dibatalkan')>Dibatalkan</option>
                </select>
                <div>
                    <label class="text-[10px] text-zinc-600">Nomor Resi (opsional)</label>
                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="Contoh: JNE123456789"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300">
                </div>
                <div>
                    <label class="text-[10px] text-zinc-600">Alamat Pengiriman (opsional)</label>
                    <textarea name="shipping_address" rows="2" placeholder="Alamat tujuan pengiriman"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-sm text-zinc-300 resize-none">{{ $order->shipping_address }}</textarea>
                </div>
                <button class="w-full rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white hover:bg-emerald-500 transition">
                    Simpan Status Pengiriman
                </button>
            </form>
        </div>

        {{-- Customer info --}}
        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Info Pembeli</h3>
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-sm font-bold text-zinc-950 shrink-0">
                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ $order->user->name }}</p>
                    <p class="text-xs text-zinc-500">@{{ $order->user->username }}</p>
                </div>
            </div>
            <div class="mt-3 space-y-1 text-xs text-zinc-500">
                <p>Metode: <span class="text-zinc-300 capitalize">{{ $order->payment_method }}</span></p>
                <p>Bergabung: <span class="text-zinc-300">{{ $order->user->created_at->format('d M Y') }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection
