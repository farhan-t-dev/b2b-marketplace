<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;

class AdminWebController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_sellers' => Seller::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentSellers = Seller::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentSellers'));
    }

    public function users()
    {
        $users = User::with('seller')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function products()
    {
        $products = Product::with('seller')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function updateProductStatus(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,active,archived',
        ]);

        $product->update(['status' => $validated['status']]);

        return back()->with('success', 'Product status updated.');
    }

    public function toggleUserStatus(User $user)
    {
        // For MVP, we'll just soft delete or use a status.
        // Let's assume we have a status or just block them.
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot suspend an admin.');
        }

        if ($user->trashed()) {
            $user->restore();
            return back()->with('success', 'User activated.');
        } else {
            $user->delete();
            return back()->with('success', 'User suspended.');
        }
    }
}
