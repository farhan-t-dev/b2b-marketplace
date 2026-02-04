<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->isAdmin() || 
               $user->id === $order->buyer_id || 
               $user->id === $order->seller->user_id;
    }

    public function updateStatus(User $user, Order $order): bool
    {
        // Only seller or admin can update order status
        return $user->isAdmin() || $user->id === $order->seller->user_id;
    }
}
