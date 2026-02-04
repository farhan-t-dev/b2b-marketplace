<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['variants', 'images', 'seller'])
            ->where('status', 'active');

        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $query->latest()->paginate(12);

        return view('home', compact('products'));
    }

    public function show(Product $product)
    {
        if ($product->status !== 'active' && (!auth()->check() || (!auth()->user()->isAdmin() && auth()->id() !== $product->seller->user_id))) {
            abort(404);
        }

        $product->load(['variants', 'images', 'seller']);
        return view('products.show', compact('product'));
    }
}