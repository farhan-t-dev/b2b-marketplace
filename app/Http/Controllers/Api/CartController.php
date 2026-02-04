<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->cartService->getCart(Auth::user()));
    }

    public function addItem(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'qty' => 'required|integer|min:1',
        ]);

        try {
            $item = $this->cartService->addItem(
                Auth::user(),
                $validated['product_variant_id'],
                $validated['qty']
            );
            return response()->json($item, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function updateQuantity(Request $request, int $itemId): JsonResponse
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        try {
            $item = $this->cartService->updateQuantity(Auth::user(), $itemId, $validated['qty']);
            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function removeItem(int $itemId): JsonResponse
    {
        $this->cartService->removeItem(Auth::user(), $itemId);
        return response()->json(['message' => 'Item removed from cart']);
    }

    public function clear(): JsonResponse
    {
        $this->cartService->clearCart(Auth::user());
        return response()->json(['message' => 'Cart cleared']);
    }
}
