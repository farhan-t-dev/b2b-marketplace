@extends('layouts.app')

@section('title', $product->title . ' - MarketPlace')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ 
    selectedVariantId: {{ $product->variants->first()->id }},
    variants: {{ $product->variants->toJson() }},
    get selectedVariant() {
        return this.variants.find(v => v.id == this.selectedVariantId);
    }
}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 p-6 lg:p-16">
        <!-- Image Gallery -->
        <div class="space-y-6" x-data="{ activeImage: '{{ $product->images->first()->url ?? '' }}' }">
            <div class="aspect-w-4 aspect-h-3 bg-slate-50 rounded-2xl overflow-hidden border border-slate-100">
                <template x-if="activeImage">
                    <img :src="activeImage" class="w-full h-full object-cover transition duration-500 transform hover:scale-105">
                </template>
                <template x-if="!activeImage">
                    <div class="w-full h-full flex items-center justify-center text-slate-400 italic">No image available</div>
                </template>
            </div>
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $image)
                    <button @click="activeImage = '{{ $image->url }}'" 
                            class="aspect-square rounded-xl overflow-hidden border-2 transition duration-200 shadow-sm" 
                            :class="activeImage === '{{ $image->url }}' ? 'border-blue-600 ring-2 ring-blue-100' : 'border-transparent hover:border-slate-300'">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Product Info -->
        <div class="flex flex-col space-y-8">
            <div class="space-y-4">
                <nav class="flex text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                    <a href="/" class="hover:text-blue-600 transition">Marketplace</a>
                    <span class="mx-2">/</span>
                    <a href="/products" class="hover:text-blue-600 transition">Products</a>
                </nav>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight">{{ $product->title }}</h1>
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-[10px] italic">Shop</div>
                    <p class="text-slate-600 font-bold">Verified Seller: <span class="text-blue-600 hover:underline cursor-pointer">{{ $product->seller->shop_name }}</span></p>
                </div>
            </div>

            <div class="flex items-baseline space-x-2">
                <span class="text-5xl font-black text-slate-900">$</span>
                <span class="text-5xl font-black text-slate-900 tracking-tighter" x-text="selectedVariant.price"></span>
            </div>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Product Description</h3>
                <p class="text-slate-600 leading-relaxed text-sm">{{ $product->description }}</p>
            </div>

            <!-- Variant Selector -->
            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Available Options</h3>
                <div class="grid grid-cols-1 gap-3">
                    <template x-for="variant in variants" :key="variant.id">
                        <button type="button" 
                                @click="selectedVariantId = variant.id"
                                class="relative flex items-center p-4 border-2 rounded-2xl cursor-pointer focus:outline-none transition text-left" 
                                :class="selectedVariantId === variant.id ? 'border-blue-600 bg-blue-50/50 shadow-md shadow-blue-100' : 'border-slate-100 hover:border-slate-300 hover:bg-slate-50'">
                            <div class="flex-grow">
                                <div class="flex justify-between items-center">
                                    <span class="font-black text-slate-900" x-text="'SKU: ' + variant.sku"></span>
                                    <span class="text-slate-900 font-black text-lg" x-text="'$' + variant.price"></span>
                                </div>
                                <div class="text-xs text-slate-500 mt-2 flex flex-wrap gap-2">
                                    <template x-for="(value, key) in variant.attributes" :key="key">
                                        <span class="bg-white border border-slate-200 px-2 py-1 rounded-md shadow-sm">
                                            <strong class="capitalize" x-text="key + ': '"></strong>
                                            <span x-text="value"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>
                            <div class="ml-4" x-show="selectedVariantId === variant.id">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Add to Cart -->
            <div class="pt-6 border-t border-slate-100 space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Inventory Status</span>
                        <span class="font-black text-sm" :class="selectedVariant.stock > 0 ? 'text-emerald-600' : 'text-rose-500'" 
                              x-text="selectedVariant.stock > 0 ? selectedVariant.stock + ' units available' : 'Currently out of stock'"></span>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="hidden" name="product_variant_id" :value="selectedVariantId">
                    <div class="w-24">
                        <input type="number" name="qty" value="1" min="1" :max="selectedVariant.stock" 
                               class="w-full h-14 bg-slate-100 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-blue-500 font-black text-center">
                    </div>
                    <button type="submit" 
                            class="flex-grow h-14 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-blue-700 transition shadow-xl shadow-blue-200 disabled:bg-slate-200 disabled:text-slate-400 disabled:shadow-none disabled:cursor-not-allowed" 
                            :disabled="selectedVariant.stock <= 0">
                        Add to Cart
                    </button>
                </form>
                <div class="flex items-center justify-center space-x-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <div class="flex items-center"><svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg> 100% Secure</div>
                    <div class="flex items-center"><svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Verified Seller</div>
                    <div class="flex items-center"><svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg> B2B Rates</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection