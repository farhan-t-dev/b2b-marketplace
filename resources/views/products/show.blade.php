@extends('layouts.app')

@section('title', $product->title . ' - MarketPlace')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ 
    selectedVariant: {{ $product->variants->first()->id }},
    variants: {{ $product->variants->toJson() }},
    get currentPrice() {
        return this.variants.find(v => v.id === this.selectedVariant).price;
    },
    get currentStock() {
        return this.variants.find(v => v.id === this.selectedVariant).stock;
    }
}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 lg:p-12">
        <!-- Image Gallery -->
        <div class="space-y-4" x-data="{ activeImage: '{{ $product->images->first()->url ?? '' }}' }">
            <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded-xl overflow-hidden">
                <template x-if="activeImage">
                    <img :src="activeImage" class="w-full h-full object-cover">
                </template>
                <template x-if="!activeImage">
                    <div class="w-full h-full flex items-center justify-center text-gray-400 italic">No image available</div>
                </template>
            </div>
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->images as $image)
                    <button @click="activeImage = '{{ $image->url }}'" class="aspect-square rounded-lg overflow-hidden border-2 transition" :class="activeImage === '{{ $image->url }}' ? 'border-blue-600' : 'border-transparent'">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Product Info -->
        <div class="flex flex-col space-y-6">
            <div>
                <nav class="flex text-sm text-gray-500 mb-2">
                    <a href="/" class="hover:text-blue-600">Products</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ $product->title }}</span>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->title }}</h1>
                <p class="text-blue-600 font-semibold mt-1">Sold by {{ $product->seller->shop_name }}</p>
            </div>

            <div class="text-4xl font-extrabold text-gray-900">
                $<span x-text="currentPrice"></span>
            </div>

            <div class="prose prose-sm text-gray-600">
                <p>{{ $product->description }}</p>
            </div>

            <hr class="border-gray-100">

            <!-- Variant Selector -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Select Variant</h3>
                <div class="grid grid-cols-1 gap-3">
                    @foreach($product->variants as $variant)
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer focus:outline-none transition" :class="selectedVariant === {{ $variant->id }} ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="variant" value="{{ $variant->id }}" x-model="selectedVariant" class="sr-only">
                            <div class="flex-grow">
                                <div class="flex justify-between">
                                    <span class="font-bold text-gray-900">SKU: {{ $variant->sku }}</span>
                                    <span class="text-gray-900 font-semibold">${{ $variant->price }}</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    @foreach($variant->attributes as $key => $value)
                                        <span class="inline-block mr-3 capitalize"><strong>{{ $key }}:</strong> {{ $value }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Add to Cart -->
            <div class="pt-6 space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="text-sm">
                        <span class="text-gray-500">Availability:</span>
                        <span class="font-bold" :class="currentStock > 0 ? 'text-green-600' : 'text-red-600'" x-text="currentStock > 0 ? currentStock + ' in stock' : 'Out of stock'"></span>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="flex space-x-4">
                    @csrf
                    <input type="hidden" name="product_variant_id" :value="selectedVariant">
                    <div class="w-24">
                        <input type="number" name="qty" value="1" min="1" :max="currentStock" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="flex-grow bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed" :disabled="currentStock <= 0">
                        Add to Cart
                    </button>
                </form>
                <p class="text-xs text-gray-400 italic text-center">Standard B2B shipping rates apply.</p>
            </div>
        </div>
    </div>
</div>
@endsection
