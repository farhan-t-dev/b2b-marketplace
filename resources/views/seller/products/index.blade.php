@extends('layouts.app')

@section('title', 'Manage Products - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="/seller/dashboard" class="p-2 rounded-full hover:bg-gray-200 transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Manage Products</h1>
        </div>
        <a href="{{ route('seller.products.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Add New Product</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Variants</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Stock</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $product->title }}</p>
                                    <p class="text-xs text-gray-500 truncate w-48">{{ $product->description }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->variants->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            {{ $product->variants->sum('stock') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded uppercase">{{ $product->status }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="/api/seller/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Archive this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Archive</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $products->links() }}
    </div>
</div>
@endsection
