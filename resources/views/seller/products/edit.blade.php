@extends('layouts.app')

@section('title', 'Edit Product - Seller Hub')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ 
    variants: {{ $product->variants->toJson() }},
    addVariant() {
        this.variants.push({ sku: '', price: '', stock: 0, attributes: { color: '', size: '' } });
    },
    removeVariant(index) {
        if (this.variants.length > 1) this.variants.splice(index, 1);
    }
}">
    <div class="mb-12">
        <div class="flex items-center space-x-4">
            <a href="{{ route('seller.products') }}" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit <span class="text-blue-600">Product</span></h1>
        </div>
    </div>

    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" class="space-y-8 pb-20">
        @csrf
        @method('PATCH')
        
        <!-- Core Details -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
            <div class="border-b border-slate-100 pb-6">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Product Details</h2>
            </div>
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Product Title</label>
                        <input type="text" name="title" id="title" required 
                               class="w-full h-14 bg-slate-50 border-slate-200 rounded-2xl px-6 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-bold text-slate-900" 
                               value="{{ old('title', $product->title) }}">
                    </div>
                    <div>
                        <label for="category_id" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Category</label>
                        <select name="category_id" id="category_id" required 
                                class="w-full h-14 bg-slate-50 border-slate-200 rounded-2xl px-6 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-bold text-slate-900">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Listing Status</label>
                    <select name="status" id="status" required 
                            class="w-full h-14 bg-slate-50 border-slate-200 rounded-2xl px-6 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-bold text-slate-900">
                        <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="archived" {{ $product->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Detailed Description</label>
                    <textarea name="description" id="description" rows="6" required 
                              class="w-full bg-slate-50 border-slate-200 rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-medium text-slate-700">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Variants -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
            <div class="flex justify-between items-end border-b border-slate-100 pb-6">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Inventory & Pricing</h2>
                <button type="button" @click="addVariant" class="bg-blue-50 text-blue-600 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-blue-100 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Add Variant
                </button>
            </div>
            
            <div class="space-y-4">
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="p-8 border-2 border-slate-50 rounded-3xl bg-slate-50/30 space-y-6 relative group transition hover:border-blue-100">
                        <button type="button" @click="removeVariant(index)" x-show="variants.length > 1" class="absolute top-6 right-6 text-slate-300 hover:text-rose-500 transition p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">SKU / ID</label>
                                <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku" required class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Unit Price ($)</label>
                                <input type="number" step="0.01" :name="'variants['+index+'][price]'" x-model="variant.price" required class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Stock Level</label>
                                <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" required class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-bold">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-blue-600 text-white px-12 py-4 rounded-[1.5rem] font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition shadow-2xl shadow-blue-200 flex items-center">
                Update Product
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </div>
    </form>
</div>
@endsection
