@extends('layouts.app')

@section('title', 'Your Cart - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
        <a href="/" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Continue Shopping
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if($cart->items->isEmpty())
        <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="/" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                Browse Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex space-x-6">
                        <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            @if($item->variant->product->images->isNotEmpty())
                                <img src="{{ $item->variant->product->images->first()->url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-900 hover:text-blue-600 transition">
                                        <a href="/products/{{ $item->variant->product_id }}">{{ $item->variant->product->title }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $item->variant->sku }}</p>
                                    <div class="text-xs text-gray-400 mt-1">
                                        @foreach($item->variant->attributes as $key => $value)
                                            <span class="inline-block mr-2 capitalize"><strong>{{ $key }}:</strong> {{ $value }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">${{ $item->variant->price }}</p>
                                    <p class="text-sm text-gray-400">Total: ${{ number_format($item->variant->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="text-sm text-gray-500">Qty:</label>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->variant->stock }}" 
                                           class="w-16 border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500"
                                           onchange="this.form.submit()">
                                </form>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900">Order Summary</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal ({{ $cart->items->sum('quantity') }} items)</span>
                            <span>${{ number_format($cart->items->sum(fn($i) => $i->variant->price * $i->quantity), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                        <hr class="border-gray-100">
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>${{ number_format($cart->items->sum(fn($i) => $i->variant->price * $i->quantity), 2) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg flex items-center justify-center space-x-2">
                            <span>Place Order</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
                        </button>
                    </form>
                    
                    <p class="text-xs text-gray-400 text-center">
                        Secure checkout powered by MarketPlace B2B. By placing an order you agree to our terms.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
