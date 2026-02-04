@extends('layouts.app')

@section('title', 'MarketPlace - B2B Multi-vendor Platform')

@section('content')
<div class="space-y-8">
    <!-- Hero -->
    <div class="bg-blue-600 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-8 py-12 sm:px-16 sm:py-20 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between">
            <div class="max-w-xl space-y-6">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white">
                    The Next-Gen B2B Marketplace.
                </h1>
                <p class="text-blue-100 text-lg sm:text-xl">
                    Connect with premium sellers, manage inventory, and grow your business with our production-grade commerce platform.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#products" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition shadow-lg text-center">
                        Browse Products
                    </a>
                    @guest
                    <a href="/register" class="bg-blue-700 text-white border border-blue-500 px-8 py-3 rounded-lg font-bold hover:bg-blue-800 transition text-center">
                        Join as Seller
                    </a>
                    @endguest
                </div>
            </div>
            <div class="hidden lg:block">
                <svg class="w-64 h-64 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div id="products" class="space-y-6">
        <div class="flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Featured Products</h2>
                <p class="text-gray-500">Discover top deals from our verified sellers.</p>
            </div>
            <a href="/products" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center">
                View all <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
                    <a href="/products/{{ $product->id }}" class="block">
                        <div class="aspect-w-4 aspect-h-3 bg-gray-200 relative overflow-hidden h-48">
                            @if($product->images->isNotEmpty())
                                <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50 italic text-sm">No image</div>
                            @endif
                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-blue-600">
                                ${{ number_format($product->variants->min('price'), 2) }}
                            </div>
                        </div>
                        <div class="p-4 space-y-2">
                            <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider">{{ $product->seller->shop_name }}</p>
                            <h3 class="text-gray-900 font-bold group-hover:text-blue-600 transition truncate">{{ $product->title }}</h3>
                            <p class="text-gray-500 text-sm line-clamp-2 h-10">{{ $product->description }}</p>
                            
                            <div class="pt-4 flex items-center justify-between border-t border-gray-100">
                                <span class="text-xs text-gray-400">{{ $product->variants->count() }} Variants</span>
                                <button class="bg-gray-100 text-gray-700 group-hover:bg-blue-600 group-hover:text-white p-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
