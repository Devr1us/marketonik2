<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function defaultNames(): array
    {
        return Product::CATEGORIES;
    }

    public static function options(): array
    {
        $names = static::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->all();

        return $names ?: static::defaultNames();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category', 'name');
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base !== '' ? $base : Str::random(8);
        $i = 0;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }
}
