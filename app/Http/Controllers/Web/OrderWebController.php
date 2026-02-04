<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderWebController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $orders = Order::with(['items.variant.product', 'seller'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items.variant.product', 'seller', 'commission']);
        return view('orders.show', compact('order'));
    }
}
