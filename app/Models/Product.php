<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    public const CATEGORIES = [
        'Laptop & Komputer',
        'Smartphone',
        'Audio & Headphone',
        'Kamera & Foto',
        'TV & Monitor',
        'Gaming',
        'Aksesoris',
        'Lainnya',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'slug',
        'description',
        'seller_location',
        'specifications',
        'price',
        'discount_percent',
        'stock',
        'image_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * URL tampilan gambar: unggahan lokal (path di disk public) atau URL absolut (seed / eksternal).
     */
    public function displayImageUrl(): ?string
    {
        $u = $this->image_url;
        if ($u === null || $u === '') {
            return null;
        }
        if (str_starts_with($u, 'http://') || str_starts_with($u, 'https://')) {
            return $u;
        }

        return asset('storage/'.$u);
    }

    public function effectivePrice(): float
    {
        $p = (float) $this->price;
        $d = min(100, max(0, (int) $this->discount_percent));

        return round($p * (1 - $d / 100), 2);
    }

    public static function uniqueSlug(int $userId, string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 0;
        while (static::where('user_id', $userId)->where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }
}
