<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = Order::with(['items.variant.product', 'seller'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->paginate(15);

        return OrderResource::collection($orders);
    }

    public function store(): JsonResponse
    {
        try {
            $order = $this->orderService->createOrderFromCart(Auth::user());
            return response()->json(new OrderResource($order), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return response()->json(new OrderResource($order->load(['items.variant.product', 'seller'])));
    }

    public function sellerOrders()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $orders = Order::with(['items.variant.product', 'buyer'])
            ->where('seller_id', $seller->id)
            ->latest()
            ->paginate(15);

        return OrderResource::collection($orders);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $this->authorize('updateStatus', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $updatedOrder = $this->orderService->updateOrderStatus($order, $validated['status']);

        return response()->json(new OrderResource($updatedOrder));
    }
}