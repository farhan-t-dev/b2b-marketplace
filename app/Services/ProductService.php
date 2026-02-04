<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function createProduct(Seller $seller, array $data): Product
    {
        return DB::transaction(function () use ($seller, $data) {
            $product = Product::create([
                'seller_id' => $seller->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'] ?? 'draft',
            ]);

            if (isset($data['variants'])) {
                foreach ($data['variants'] as $variantData) {
                    $product->variants()->create([
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'],
                        'attributes' => $variantData['attributes'] ?? [],
                    ]);
                }
            }

            if (isset($data['images'])) {
                foreach ($data['images'] as $index => $imageUrl) {
                    $product->images()->create([
                        'url' => $imageUrl,
                        'sort_order' => $index,
                    ]);
                }
            }

            return $product->load(['variants', 'images']);
        });
    }

    public function updateProduct(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update(array_filter([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'status' => $data['status'] ?? null,
            ]));

            if (isset($data['variants'])) {
                // For simplicity in MVP, we might just replace variants or update existing ones
                // Here we'll do a simple update or create based on SKU
                foreach ($data['variants'] as $variantData) {
                    $product->variants()->updateOrCreate(
                        ['sku' => $variantData['sku']],
                        [
                            'price' => $variantData['price'],
                            'stock' => $variantData['stock'],
                            'attributes' => $variantData['attributes'] ?? [],
                        ]
                    );
                }
            }

            return $product->load(['variants', 'images']);
        });
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete(); // Soft delete
    }
}
