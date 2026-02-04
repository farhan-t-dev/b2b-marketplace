@extends('layouts.app')

@section('title', 'Seller Dashboard - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Seller Dashboard</h1>
        <div class="flex space-x-4">
            <a href="/seller/products" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Manage Products</a>
            <a href="/seller/orders" class="bg-white border border-gray-200 px-4 py-2 rounded-lg font-bold hover:bg-gray-50 transition">View All Orders</a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Total Products</p>
            <p class="text-3xl font-black text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Active Orders</p>
            <p class="text-3xl font-black text-blue-600 mt-1">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Pending Fulfillment</p>
            <p class="text-3xl font-black text-orange-500 mt-1">{{ $stats['pending_orders'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Delivered Revenue</p>
            <p class="text-3xl font-black text-green-600 mt-1">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-900">Recent Orders</h2>
                <a href="/seller/orders" class="text-sm text-blue-600 font-bold hover:underline">View All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($recentOrders as $order)
                    <div class="p-6 flex justify-between items-center hover:bg-gray-50 transition">
                        <div>
                            <p class="font-bold text-gray-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-sm text-gray-500">By {{ $order->buyer->name }} • {{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                            <span class="text-xs font-bold uppercase @if($order->status === 'pending') text-orange-500 @else text-blue-500 @endif">{{ $order->status }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Latest Products -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-900">Top Products</h2>
                <a href="/seller/products" class="text-sm text-blue-600 font-bold hover:underline">Manage</a>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($topProducts as $product)
                    <div class="p-6 flex items-center space-x-4 hover:bg-gray-50 transition">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if($product->images->isNotEmpty())
                                <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-grow">
                            <p class="font-bold text-gray-900 truncate">{{ $product->title }}</p>
                            <p class="text-sm text-gray-500">{{ $product->variants_count }} Variants</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded uppercase">{{ $product->status }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
