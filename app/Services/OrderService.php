<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrderFromCart(User $user): Order
    {
        $cart = $this->cartService->getCart($user);

        if ($cart->items->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        return DB::transaction(function () use ($user, $cart) {
            // Group items by seller
            $itemsBySeller = $cart->items->groupBy(function ($item) {
                return $item->variant->product->seller_id;
            });

            $orders = [];

            foreach ($itemsBySeller as $sellerId => $items) {
                $total = $items->sum(function ($item) {
                    return $item->quantity * $item->variant->price;
                });

                $order = Order::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $sellerId,
                    'total' => $total,
                    'status' => 'pending',
                ]);

                foreach ($items as $item) {
                    $variant = $item->variant;

                    if ($variant->stock < $item->quantity) {
                        throw new \Exception("Insufficient stock for SKU: {$variant->sku}");
                    }

                    // Create order item with price snapshot
                    $order->items()->create([
                        'product_variant_id' => $variant->id,
                        'quantity' => $item->quantity,
                        'price_snapshot' => $variant->price,
                    ]);

                    // Deduct stock
                    $variant->decrement('stock', $item->quantity);
                }

                // Calculate commission (10% flat for MVP)
                $commissionRate = 0.10;
                $commissionAmount = $total * $commissionRate;

                Commission::create([
                    'order_id' => $order->id,
                    'seller_id' => $sellerId,
                    'rate' => $commissionRate * 100, // percentage
                    'amount' => $commissionAmount,
                ]);

                $orders[] = $order;
            }

            // Clear cart
            $this->cartService->clearCart($user);

            return $orders[0]->load('items', 'seller');
        });
    }

    public function updateOrderStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);
        return $order;
    }
}
