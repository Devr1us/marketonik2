<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (Category::defaultNames() as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                [
                    'slug' => Category::uniqueSlug($name),
                    'description' => 'Kategori produk '.$name,
                    'is_active' => true,
                ]
            );
        }
    }
}
