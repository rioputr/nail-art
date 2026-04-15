<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    public function run()
    {
        $collections = [
            [
                'name' => 'Summer Vibes 2025',
                'description' => 'Bright and cheerful colors perfect for your summer beach trips.',
                'image' => 'collections/summer.jpg',
                'is_published' => true,
                'keywords' => ['Summer', 'Red', 'Blue', 'Gold']
            ],
            [
                'name' => 'Wedding Essentials',
                'description' => 'Elegant, soft, and classy styles for the perfect bride.',
                'image' => 'collections/wedding.jpg',
                'is_published' => true,
                'keywords' => ['Pink', 'Crystal', 'White', 'Chrome']
            ],
            [
                'name' => 'Pro Artist Picks',
                'description' => 'Tools and supplies recommended by top nail technicians.',
                'image' => 'collections/pro.jpg',
                'is_published' => true,
                'keywords' => ['Lamp', 'File', 'Oil', 'Remover']
            ],
            [
                'name' => 'Glitter & Glam',
                'description' => 'For those who love to shine. Best suited for parties.',
                'image' => 'collections/glitter.jpg',
                'is_published' => false, // Draft
                'keywords' => ['Glitter', 'Foil', 'Chrome', 'Swarovski']
            ],
        ];

        foreach ($collections as $colData) {
            $keywords = $colData['keywords'];
            unset($colData['keywords']);

            $slug = Str::slug($colData['name']);
            
            $collection = Collection::updateOrCreate(
                ['slug' => $slug],
                array_merge($colData, ['slug' => $slug])
            );

            // Attach products matching keywords roughly
            $products = Product::where(function($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->orWhere('name', 'LIKE', "%{$word}%")
                          ->orWhere('description', 'LIKE', "%{$word}%");
                }
            })->limit(5)->get();

            if ($products->count() > 0) {
                $collection->products()->attach($products->pluck('id'));
            } else {
                // Fallback: attach 3 random products
                $collection->products()->attach(Product::inRandomOrder()->limit(3)->pluck('id'));
            }
        }
    }
}
