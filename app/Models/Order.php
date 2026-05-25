<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'subtotal',
        'discount_amount',
        'total',
        'payment_method',
        'payment_status',
        'payment_note',
        'payment_proof_path',
        'shipping_status',
        'shipping_address',
        'tracking_number',
    ];

    public function shippingStatusLabel(): string
    {
        return match ($this->shipping_status) {
            'menunggu'  => 'Menunggu Konfirmasi',
            'diproses'  => 'Sedang Diproses',
            'dikirim'   => 'Dalam Pengiriman',
            'selesai'   => 'Selesai',
            'dibatalkan'=> 'Dibatalkan',
            default     => ucfirst($this->shipping_status),
        };
    }

    public function shippingStatusColor(): string
    {
        return match ($this->shipping_status) {
            'menunggu'   => 'text-yellow-300 border-yellow-500/30 bg-yellow-500/10',
            'diproses'   => 'text-sky-300 border-sky-500/30 bg-sky-500/10',
            'dikirim'    => 'text-blue-300 border-blue-500/30 bg-blue-500/10',
            'selesai'    => 'text-emerald-300 border-emerald-500/30 bg-emerald-500/10',
            'dibatalkan' => 'text-rose-300 border-rose-500/30 bg-rose-500/10',
            default      => 'text-zinc-300 border-white/15',
        };
    }

    public function paymentStatusColor(): string
    {
        return match ($this->payment_status) {
            'lunas', 'paid' => 'text-emerald-300 border-emerald-500/30 bg-emerald-500/10',
            'menunggu', 'pending' => 'text-yellow-300 border-yellow-500/30 bg-yellow-500/10',
            'cancelled'     => 'text-rose-300 border-rose-500/30 bg-rose-500/10',
            default         => 'text-zinc-300 border-white/15',
        };
    }

    public function paymentProofUrl(): ?string
    {
        if (! $this->payment_proof_path) {
            return null;
        }

        return asset('storage/'.$this->payment_proof_path);
    }

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
