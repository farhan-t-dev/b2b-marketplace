<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['variants', 'images', 'seller', 'category'])
            ->where('status', 'active');

        // Search Filter
        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Category Filter
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    // Join with variants to sort by min price
                    $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                          ->select('products.*', \DB::raw('MIN(product_variants.price) as min_price'))
                          ->groupBy('products.id')
                          ->orderBy('min_price', 'asc');
                    break;
                case 'price_high':
                    $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                          ->select('products.*', \DB::raw('MIN(product_variants.price) as min_price'))
                          ->groupBy('products.id')
                          ->orderBy('min_price', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        $view = request()->routeIs('home') ? 'home' : 'products.index';
        return view($view, compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if ($product->status !== 'active' && (!auth()->check() || (!auth()->user()->isAdmin() && auth()->id() !== $product->seller->user_id))) {
            abort(404);
        }

        $product->load(['variants', 'images', 'seller', 'category']);
        return view('products.show', compact('product'));
    }

    public function categories()
    {
        $categories = Category::withCount(['products' => function($query) {
            $query->where('status', 'active');
        }])->get();
        
        return view('categories.index', compact('categories'));
    }
}
