<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $query = Product::with(['variants', 'images', 'seller'])
            ->where('status', 'active');

        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        return ProductResource::collection($query->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.attributes' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'url',
        ]);

        $product = $this->productService->createProduct(Auth::user()->seller, $validated);

        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        $this->authorize('view', $product);

        return response()->json(new ProductResource($product->load(['variants', 'images', 'seller'])));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive,draft',
            'variants' => 'sometimes|array',
            'variants.*.sku' => 'required_with:variants|string',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.attributes' => 'nullable|array',
        ]);

        $updatedProduct = $this->productService->updateProduct($product, $validated);

        return response()->json(new ProductResource($updatedProduct));
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', $product);

        $this->productService->deleteProduct($product);

        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function sellerProducts()
    {
        $seller = Auth::user()->seller;
        
        if (!$seller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $products = Product::with(['variants', 'images'])
            ->where('seller_id', $seller->id)
            ->paginate(15);

        return ProductResource::collection($products);
    }
}