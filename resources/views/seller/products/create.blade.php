@extends('layouts.app')

@section('title', 'Launch Product - Seller Hub')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ 
    step: 1,
    imageSource: 'upload',
    variants: [{ sku: '', price: '', stock: 0, color: '', size: '' }],
    previews: [],
    fileError: '',
    addVariant() {
        this.variants.push({ sku: '', price: '', stock: 0, color: '', size: '' });
    },
    removeVariant(index) {
        if (this.variants.length > 1) this.variants.splice(index, 1);
    },
    handleFileSelect(event) {
        this.previews = [];
        this.fileError = '';
        const files = event.target.files;
        const maxSize = 2 * 1024 * 1024; // 2MB

        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                this.fileError = 'One or more files exceed the 2MB limit.';
                event.target.value = '';
                this.previews = [];
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                this.previews.push(e.target.result);
            };
            reader.readAsDataURL(files[i]);
        }
    }
}">
    <!-- Progress Header -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('seller.products') }}" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition group">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Launch <span class="text-blue-600">Product</span></h1>
            </div>
            <div class="flex items-center space-x-2">
                <template x-for="i in [1, 2, 3]">
                    <div class="h-2 w-12 rounded-full transition-colors duration-500" :class="step >= i ? 'bg-blue-600' : 'bg-slate-200'"></div>
                </template>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0 text-rose-500">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3">
                    <ul class="list-disc list-inside text-sm font-bold text-rose-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-20" id="productForm">
        @csrf
        
        <!-- Step 1: Core Details -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
                <div class="border-b border-slate-100 pb-6">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Product Details</h2>
                    <p class="text-slate-500 text-sm font-medium mt-1">Start with the basics. These will be visible to everyone.</p>
                </div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Product Title</label>
                            <input type="text" name="title" id="title" :required="step === 1"
                                   class="w-full h-14 bg-slate-50 border-slate-200 rounded-2xl px-6 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-bold text-slate-900 placeholder-slate-300" 
                                   placeholder="e.g. Premium Cotton Business Shirts"
                                   value="{{ old('title') }}">
                        </div>
                        <div>
                            <label for="category_id" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Category</label>
                            <select name="category_id" id="category_id" :required="step === 1"
                                    class="w-full h-14 bg-slate-50 border-slate-200 rounded-2xl px-6 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-bold text-slate-900">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Detailed Description</label>
                        <textarea name="description" id="description" rows="6" :required="step === 1"
                                  class="w-full bg-slate-50 border-slate-200 rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition font-medium text-slate-700 placeholder-slate-300"
                                  placeholder="Describe your product's materials, benefits, and specifications...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" @click="step = 2" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-800 transition shadow-xl shadow-slate-200 flex items-center">
                        Next: Inventory
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 2: Variants & Inventory -->
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
                <div class="flex justify-between items-end border-b border-slate-100 pb-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Inventory & Pricing</h2>
                        <p class="text-slate-500 text-sm font-medium mt-1">Manage SKUs, stock levels, and price points.</p>
                    </div>
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
                                    <input type="text" :name="'variants['+index+'][sku]'" :required="step === 2" class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-bold" placeholder="PRD-BLUE-LG">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Unit Price ($)</label>
                                    <input type="number" step="0.01" :name="'variants['+index+'][price]'" :required="step === 2" class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-bold" placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Initial Stock</label>
                                    <input type="number" :name="'variants['+index+'][stock]'" :required="step === 2" class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-bold" placeholder="0">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Color (Optional)</label>
                                    <input type="text" :name="'variants['+index+'][attributes][color]'" class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-medium" placeholder="e.g. Navy Blue">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Size (Optional)</label>
                                    <input type="text" :name="'variants['+index+'][attributes][size]'" class="w-full h-12 bg-white border-slate-200 rounded-xl px-4 focus:ring-2 focus:ring-blue-500 transition font-medium" placeholder="e.g. Large / 42">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex justify-between pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 1" class="text-slate-500 px-8 py-4 font-bold text-sm hover:text-slate-900 transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
                        Back
                    </button>
                    <button type="button" @click="step = 3" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-800 transition shadow-xl shadow-slate-200 flex items-center">
                        Next: Visuals
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 3: Media & Finish -->
        <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
                <div class="border-b border-slate-100 pb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Visual Identity</h2>
                            <p class="text-slate-500 text-sm font-medium mt-1">High-quality images increase trust and sales.</p>
                        </div>
                        <div class="flex p-1 bg-slate-100 rounded-xl">
                            <button type="button" @click="imageSource = 'upload'" :class="imageSource === 'upload' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500'" class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition">Upload</button>
                            <button type="button" @click="imageSource = 'url'" :class="imageSource === 'url' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500'" class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition">URLs</button>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <!-- File Upload Option -->
                    <div x-show="imageSource === 'upload'" class="space-y-6">
                        <div class="relative">
                            <input type="file" name="images[]" id="images" multiple :required="step === 3 && imageSource === 'upload'" @change="handleFileSelect"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                            <div class="border-4 border-dashed rounded-[2rem] p-12 text-center group transition-colors duration-300"
                                 :class="fileError ? 'border-rose-200 bg-rose-50/30' : 'border-slate-100 bg-slate-50/50 hover:border-blue-200'">
                                <div class="h-20 w-20 rounded-3xl bg-blue-50 flex items-center justify-center text-blue-600 mx-auto mb-6 group-hover:scale-110 transition duration-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-lg font-black text-slate-900 tracking-tight">Drop images here or click to browse</p>
                                <p class="text-slate-400 text-sm font-bold mt-1 uppercase tracking-widest">Max 2MB per file</p>
                            </div>
                        </div>
                        <p x-show="fileError" x-text="fileError" class="text-rose-600 text-xs font-black uppercase tracking-widest text-center"></p>
                    </div>

                    <!-- URL Option -->
                    <div x-show="imageSource === 'url'" class="space-y-4">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Image URLs (one per line)</label>
                        <textarea name="image_urls" rows="4" :required="step === 3 && imageSource === 'url'"
                                  class="w-full bg-slate-50 border-slate-200 rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-blue-50 transition font-medium text-slate-700"
                                  placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg"></textarea>
                    </div>

                    <!-- Image Previews -->
                    <template x-if="previews.length > 0">
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                            <template x-for="(preview, index) in previews" :key="index">
                                <div class="aspect-square rounded-2xl overflow-hidden border border-slate-200 relative group shadow-sm">
                                    <img :src="preview" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </template>

                    <div class="p-6 bg-blue-50 rounded-2xl border border-blue-100 flex items-start space-x-4">
                        <div class="h-8 w-8 rounded-lg bg-white flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="text-xs text-blue-700 leading-relaxed font-medium">
                            <strong>Note:</strong> Your product will be saved as a <span class="font-black">Draft</span> first. You can publish it live after one final review in your catalog.
                        </p>
                    </div>
                </div>

                <div class="flex justify-between pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 2" class="text-slate-500 px-8 py-4 font-bold text-sm hover:text-slate-900 transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
                        Back
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-12 py-4 rounded-[1.5rem] font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition shadow-2xl shadow-blue-200 flex items-center">
                        Ready to Launch
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
