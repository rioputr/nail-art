<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Nail Polishes
            [
                'name' => 'Classic Red Gel Polish',
                'price' => 125000,
                'category_id' => null, 
                'stock' => 50,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'A vibrant, long-lasting classic red gel polish perfect for any occasion.',
                'image' => 'products/polish-red.jpg',
            ],
            [
                'name' => 'Pastel Pink Enamel',
                'price' => 85000,
                'category_id' => null,
                'stock' => 30,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'Soft pastel pink shade that gives a natural and elegant look.',
                'image' => 'products/polish-pink.jpg',
            ],
            [
                'name' => 'Midnight Blue Matte',
                'price' => 135000,
                'category_id' => null,
                'stock' => 20,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Deep blue matte finish for a modern and sophisticated style.',
                'image' => 'products/polish-blue.jpg',
            ],
            [
                'name' => 'Glitter Gold Top Coat',
                'price' => 110000,
                'category_id' => null,
                'stock' => 45,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Add some sparkle to your manicure with this high-shine gold glitter top coat.',
                'image' => 'products/polish-gold.jpg',
            ],
            
            // Care & Tools
            [
                'name' => 'Professional Cuticle Oil',
                'price' => 95000,
                'category_id' => null,
                'stock' => 100,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'Nourishing oil to keep cuticles soft and healthy.',
                'image' => 'products/care-oil.jpg',
            ],
            [
                'name' => 'UV LED Nail Lamp',
                'price' => 450000,
                'category_id' => null,
                'stock' => 15,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'High-power 48W UV LED lamp for fast curing of gel polishes.',
                'image' => 'products/tool-lamp.jpg',
            ],
            [
                'name' => 'Nail File Set (5pcs)',
                'price' => 50000,
                'category_id' => null,
                'stock' => 200,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Set of professional grade nail files for shaping and smoothing.',
                'image' => 'products/tool-files.jpg',
            ],
            [
                'name' => 'Gel Remover Clips',
                'price' => 35000,
                'category_id' => null,
                'stock' => 80,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Reusable clips for easy removal of soak-off gel polish.',
                'image' => 'products/tool-clips.jpg',
            ],

            // Nail Art Accessories
            [
                'name' => 'Swarovski Crystal Set',
                'price' => 250000,
                'category_id' => null,
                'stock' => 25,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'Premium Swarovski crystals for luxurious nail art designs.',
                'image' => 'products/art-crystal.jpg',
            ],
            [
                'name' => 'Holographic Foil Paper',
                'price' => 45000,
                'category_id' => null,
                'stock' => 60,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Create stunning metallic effects with these transfer foils.',
                'image' => 'products/art-foil.jpg',
            ],
            [
                'name' => '3D Flower Stickers',
                'price' => 30000,
                'category_id' => null,
                'stock' => 150,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Easy to apply 3D stickers for instant floral nail art.',
                'image' => 'products/art-flower.jpg',
            ],
            [
                'name' => 'Chrome Powder Mirror Effect',
                'price' => 180000,
                'category_id' => null,
                'stock' => 40,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'Fine powder to achieve a mirror-like chrome finish on nails.',
                'image' => 'products/art-chrome.jpg',
            ],

             // Collections Items (simulated)
            [
                'name' => 'Summer Breeze Palette',
                'price' => 300000,
                'category_id' => null,
                'stock' => 10,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'A curated set of 3 summer colors.',
                'image' => 'products/set-summer.jpg',
            ],
            [
                'name' => 'Wedding Day Kit',
                'price' => 400000,
                'category_id' => null,
                'stock' => 8,
                'status' => 'active',
                'is_popular' => false,
                'description' => 'Everything you need for varied bridal looks.',
                'image' => 'products/set-wedding.jpg',
            ],
             [
                'name' => 'Starter Manicure Kit',
                'price' => 550000,
                'category_id' => null,
                'stock' => 5,
                'status' => 'active',
                'is_popular' => true,
                'description' => 'Complete kit with lamp, tools, and basic colors.',
                'image' => 'products/set-starter.jpg',
            ],
             [
                'name' => 'Discontinued Purple',
                'price' => 70000,
                'category_id' => null,
                'stock' => 0,
                'status' => 'inactive',
                'is_popular' => false,
                'description' => 'Old stock, sold out.',
                'image' => 'products/polish-purple.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                array_merge($product, [
                    'slug' => Str::slug($product['name']) . '-' . Str::random(5)
                ])
            );
        }
    }
}
