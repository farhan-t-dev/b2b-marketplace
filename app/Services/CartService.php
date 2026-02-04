<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id])->load('items.variant.product');
    }

    public function addItem(User $user, int $productVariantId, int $quantity): CartItem
    {
        $cart = $this->getCart($user);
        $variant = ProductVariant::findOrFail($productVariantId);

        if ($variant->stock < $quantity) {
            throw new \Exception('Insufficient stock');
        }

        return DB::transaction(function () use ($cart, $productVariantId, $quantity) {
            $item = $cart->items()->where('product_variant_id', $productVariantId)->first();

            if ($item) {
                $item->update(['quantity' => $item->quantity + $quantity]);
            } else {
                $item = $cart->items()->create([
                    'product_variant_id' => $productVariantId,
                    'quantity' => $quantity,
                ]);
            }

            return $item;
        });
    }

    public function updateQuantity(User $user, int $cartItemId, int $quantity): CartItem
    {
        $item = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($cartItemId);

        if ($item->variant->stock < $quantity) {
            throw new \Exception('Insufficient stock');
        }

        $item->update(['quantity' => $quantity]);

        return $item;
    }

    public function removeItem(User $user, int $cartItemId): bool
    {
        $item = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($cartItemId);

        return $item->delete();
    }

    public function clearCart(User $user): bool
    {
        $cart = $this->getCart($user);
        return $cart->items()->delete() >= 0;
    }
}