<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies'],
            ['name' => 'Industrial Equipment', 'slug' => 'industrial-equipment'],
            ['name' => 'Textiles', 'slug' => 'textiles'],
            ['name' => 'Raw Materials', 'slug' => 'raw-materials'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        $allCategories = \App\Models\Category::all();

        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@marketplace.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Sellers
        $sellers = User::factory(5)->create(['role' => 'seller'])->map(function ($user) {
            return Seller::create([
                'user_id' => $user->id,
                'shop_name' => fake()->company() . ' Shop',
                'description' => fake()->paragraph(),
                'status' => 'active',
            ]);
        });

        // Buyers
        User::factory(10)->create(['role' => 'buyer']);

        // Products for each seller
        foreach ($sellers as $seller) {
            Product::factory(10)->create([
                'seller_id' => $seller->id,
                'category_id' => $allCategories->random()->id,
                'status' => 'active',
            ])->each(function ($product) {
                // Create 2-4 variants for each product
                $variantCount = rand(2, 4);
                for ($i = 0; $i < $variantCount; $i++) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(fake()->unique()->bothify('SKU-####-????')),
                        'price' => fake()->randomFloat(2, 10, 1000),
                        'stock' => rand(0, 100),
                        'attributes' => [
                            'size' => fake()->randomElement(['S', 'M', 'L', 'XL']),
                            'color' => fake()->safeColorName(),
                        ],
                    ]);
                }

                // Add dummy images
                for ($i = 0; $i < 3; $i++) {
                    $product->images()->create([
                        'url' => "https://picsum.photos/seed/" . rand(1, 10000) . "/800/600",
                        'sort_order' => $i,
                    ]);
                }
            });
        }
    }
}
