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
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'pending_sellers' => Seller::where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentSellers = Seller::with('user')->latest()->take(5)->get();
        $recentOrders = Order::with(['buyer', 'seller'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentSellers', 'recentOrders'));
    }

    public function users()
    {
        $users = User::withTrashed()->with('seller')->latest()->paginate(15);
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

    public function approveSeller(Seller $seller)
    {
        $seller->update(['status' => 'active']);
        return back()->with('success', "Shop '{$seller->shop_name}' has been verified and is now live.");
    }
}