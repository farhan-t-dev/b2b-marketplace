<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartWebController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart(Auth::user());
        return view('cart.index', compact('cart'));
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'qty' => 'required|integer|min:1',
        ]);

        try {
            $this->cartService->addItem(Auth::user(), $validated['product_variant_id'], $validated['qty']);
            return redirect()->route('cart.index')->with('success', 'Item added to cart!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateQuantity(Request $request, int $itemId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $this->cartService->updateQuantity(Auth::user(), $itemId, $validated['quantity']);
            return back()->with('success', 'Cart updated!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function removeItem(int $itemId)
    {
        $this->cartService->removeItem(Auth::user(), $itemId);
        return back()->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        try {
            $order = $this->orderService->createOrderFromCart(Auth::user());
            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
