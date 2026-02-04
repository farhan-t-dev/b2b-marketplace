<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerWebController extends Controller
{
    public function dashboard()
    {
        $seller = Auth::user()->seller;
        
        if (!$seller) {
            abort(403, 'You are not a seller.');
        }

        $stats = [
            'total_products' => $seller->products()->count(),
            'total_orders' => $seller->orders()->count(),
            'total_revenue' => $seller->orders()->where('status', 'delivered')->sum('total'),
            'pending_orders' => $seller->orders()->where('status', 'pending')->count(),
        ];

        $recentOrders = $seller->orders()->with('buyer')->latest()->take(5)->get();
        $topProducts = $seller->products()->withCount('variants')->latest()->take(5)->get();

        return view('seller.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }

    public function products()
    {
        $products = Auth::user()->seller->products()->with(['variants', 'images'])->latest()->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = \App\Models\Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(Request $request, \App\Services\ProductService $productService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.attributes' => 'nullable|array',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $productService->createProduct(Auth::user()->seller, $validated);

        return redirect()->route('seller.products')->with('success', 'Product created successfully as draft!');
    }

    public function editProduct(Product $product)
    {
        $this->authorize('update', $product);
        $categories = \App\Models\Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product, \App\Services\ProductService $productService)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,active,archived',
            'variants' => 'sometimes|array',
            'variants.*.sku' => 'required_with:variants|string',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.attributes' => 'nullable|array',
        ]);

        $productService->updateProduct($product, $validated);

        return redirect()->route('seller.products')->with('success', 'Product updated successfully!');
    }

    public function publishProduct(Product $product)
    {
        $this->authorize('update', $product);
        $product->update(['status' => 'active']);
        return back()->with('success', 'Product is now live on the marketplace!');
    }

    public function orders()
    {
        $orders = Auth::user()->seller->orders()->with(['buyer', 'items'])->latest()->paginate(10);
        return view('seller.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully!');
    }
}
