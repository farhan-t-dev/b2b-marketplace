@extends('layouts.app')

@section('title', 'Add New Product - MarketPlace')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{ 
    variants: [{ sku: '', price: '', stock: 0, attributes: {} }],
    addVariant() {
        this.variants.push({ sku: '', price: '', stock: 0, attributes: {} });
    },
    removeVariant(index) {
        if (this.variants.length > 1) this.variants.splice(index, 1);
    }
}">
    <div class="flex items-center space-x-4">
        <a href="{{ route('seller.products') }}" class="p-2 rounded-full hover:bg-gray-200 transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
    </div>

    <form action="{{ route('seller.products.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Basic Info -->
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6">
            <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4">Basic Information</h2>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Product Title</label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('title') }}">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Variants -->
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6">
            <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                <h2 class="text-xl font-bold text-gray-900">Product Variants</h2>
                <button type="button" @click="addVariant" class="text-sm bg-blue-50 text-blue-600 px-4 py-2 rounded-lg font-bold hover:bg-blue-100 transition">+ Add Variant</button>
            </div>
            
            <div class="space-y-4">
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="p-6 border border-gray-100 rounded-xl bg-gray-50/50 space-y-4 relative">
                        <button type="button" @click="removeVariant(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">SKU</label>
                                <input type="text" :name="'variants['+index+'][sku]'" required class="mt-1 block w-full border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Price ($)</label>
                                <input type="number" step="0.01" :name="'variants['+index+'][price]'" required class="mt-1 block w-full border-gray-200 rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Stock</label>
                                <input type="number" :name="'variants['+index+'][stock]'" required class="mt-1 block w-full border-gray-200 rounded-lg text-sm">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6">
            <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4">Images</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image URLs (one per line)</label>
                    <textarea name="images[]" rows="3" placeholder="https://example.com/image1.jpg" class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <p class="mt-2 text-xs text-gray-400">For this MVP, please provide direct URLs to images.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-blue-600 text-white px-12 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-xl">
                Publish Product
            </button>
        </div>
    </form>
</div>
@endsection
