@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4">
        <a href="{{ route('orders.index') }}" class="p-2 rounded-full hover:bg-gray-200 transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-bold text-gray-900">Items Ordered</h2>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                        @if($order->status === 'delivered') bg-green-100 text-green-700 
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                        @else bg-blue-100 text-blue-700 @endif">
                        {{ $order->status }}
                    </span>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-6 flex space-x-6">
                            <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($item->variant->product->images->isNotEmpty())
                                    <img src="{{ $item->variant->product->images->first()->url }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $item->variant->product->title }}</h3>
                                        <p class="text-sm text-gray-500">SKU: {{ $item->variant->sku }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">${{ $item->price_snapshot }} x {{ $item->quantity }}</p>
                                        <p class="text-sm font-bold text-blue-600">${{ number_format($item->price_snapshot * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Summary & Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-gray-900">Order Summary</h2>
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Date Placed</span>
                        <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Seller</span>
                        <span class="font-medium text-blue-600">{{ $order->seller->shop_name }}</span>
                    </div>
                    <hr class="border-gray-100">
                    <div class="flex justify-between text-lg font-bold text-gray-900">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                <h3 class="font-bold text-blue-900 mb-2">Need Help?</h3>
                <p class="text-sm text-blue-700 mb-4">If you have any issues with your order, please contact the seller directly.</p>
                <a href="#" class="text-blue-600 font-bold text-sm hover:underline">Contact Support</a>
            </div>
        </div>
    </div>
</div>
@endsection
