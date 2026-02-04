<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function createProduct(Seller $seller, array $data): Product
    {
        return DB::transaction(function () use ($seller, $data) {
            $product = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $data['category_id'] ?? null,
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

            // Handle Image Uploads
            if (isset($data['images'])) {
                foreach ($data['images'] as $index => $image) {
                    if ($image instanceof UploadedFile) {
                        $path = $image->store('products', 'public');
                        $url = Storage::url($path);
                    } else {
                        $url = $image;
                    }

                    if ($url) {
                        $product->images()->create([
                            'url' => $url,
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            return $product->load(['variants', 'images', 'category']);
        });
    }

    public function updateProduct(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update(array_filter([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'status' => $data['status'] ?? null,
                'category_id' => $data['category_id'] ?? null,
            ]));

            if (isset($data['variants'])) {
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

            return $product->load(['variants', 'images', 'category']);
        });
    }

    public function deleteProduct(Product $product): bool
    {
        foreach ($product->images as $image) {
            if (str_contains($image->url, '/storage/')) {
                $path = str_replace('/storage/', '', $image->url);
                Storage::disk('public')->delete($path);
            }
        }
        
        return $product->delete();
    }
}
