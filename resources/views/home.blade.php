@extends('layouts.app')

@section('title', 'MarketFlow - Global B2B Multi-vendor Commerce')

@section('content')
<div class="space-y-24 pb-20">
    <!-- 1. Hero Section -->
    <section class="relative">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <div class="flex-1 text-center lg:text-left space-y-8">
                <div class="inline-flex items-center space-x-2 bg-blue-50 px-3 py-1 rounded-full text-blue-600 font-bold text-[10px] uppercase tracking-wider border border-blue-100">
                    <span>New: Enterprise Tier Now Live</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold text-slate-900 leading-[1.1] tracking-tight">
                    Source global supplies <span class="text-blue-600">effortlessly.</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    The leading multi-vendor platform for professional procurement. Connect with verified manufacturers and manage your entire supply chain in one place.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('products.index') }}" class="bg-slate-900 text-white px-8 py-4 rounded-xl font-bold text-sm hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                        Browse Full Catalog
                    </a>
                    @guest
                        <a href="/register?role=seller" class="bg-white text-slate-900 border border-slate-200 px-8 py-4 rounded-xl font-bold text-sm hover:bg-slate-50 transition">
                            Become a Seller
                        </a>
                    @endguest
                </div>
            </div>
            
            <div class="flex-1 w-full max-w-2xl">
                <div class="relative">
                    <div class="aspect-w-16 aspect-h-10 bg-slate-200 rounded-[2rem] overflow-hidden shadow-2xl border border-white">
                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=1000" 
                             class="w-full h-full object-cover" alt="Logistics and Commerce">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 hidden md:block">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 bg-emerald-500 rounded-lg flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">Verified Sellers Only</p>
                                <p class="text-xs text-slate-500">Industry standards compliance</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Trust Bar / Stats -->
    <section class="border-y border-slate-200 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-1">
                <p class="text-3xl font-bold text-slate-900">500+</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Global Vendors</p>
            </div>
            <div class="space-y-1 border-l border-slate-200">
                <p class="text-3xl font-bold text-slate-900">12k+</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Successful Shipments</p>
            </div>
            <div class="space-y-1 border-l border-slate-200">
                <p class="text-3xl font-bold text-slate-900">24/7</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Procurement Support</p>
            </div>
            <div class="space-y-1 border-l border-slate-200">
                <p class="text-3xl font-bold text-slate-900">Secure</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Escrow Protection</p>
            </div>
        </div>
    </section>

    <!-- 3. Category Grid -->
    <section class="space-y-10">
        <div class="flex items-end justify-between px-2">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Shop by Industry</h2>
                <p class="text-slate-500 font-medium mt-1">Specialized marketplaces for your specific business needs.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="text-blue-600 font-bold text-sm hover:underline">View All Categories &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories->take(4) as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="group bg-white p-2 rounded-3xl border border-slate-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300">
                    <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden relative">
                        <img src="https://picsum.photos/seed/{{ $category->slug }}/400/400" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition duration-300"></div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 group-hover:text-blue-600 transition">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">{{ $category->products_count ?? 'Browse' }} Listings</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- 4. Featured Products -->
    <section class="space-y-10">
        <div class="flex items-end justify-between px-2 border-b border-slate-100 pb-6">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight text-blue-600">Top Sourced</h2>
                <p class="text-slate-500 font-medium mt-1">Recently published and ready for shipment.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-slate-900 font-bold text-sm border-b-2 border-slate-900 pb-1">Browse Catalog</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                    <a href="{{ route('products.show', $product->id) }}" class="block relative flex-grow">
                        <div class="aspect-w-4 aspect-h-3 bg-slate-50">
                            @if($product->images->isNotEmpty())
                                <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-blue-600 uppercase">{{ $product->category->name ?? 'Industrial' }}</span>
                                <span class="text-[10px] font-medium text-slate-400">{{ $product->seller->shop_name }}</span>
                            </div>
                            <h3 class="font-bold text-slate-900 leading-snug truncate">{{ $product->title }}</h3>
                            <div class="flex items-center justify-between pt-2">
                                <p class="text-lg font-bold text-slate-900">${{ number_format($product->variants->min('price'), 2) }}</p>
                                <span class="text-[10px] font-bold py-1 px-2 rounded bg-emerald-50 text-emerald-700 uppercase">In Stock</span>
                            </div>
                        </div>
                    </a>
                    <div class="p-5 pt-0 mt-auto">
                        <a href="{{ route('products.show', $product->id) }}" class="block w-full text-center bg-slate-50 text-slate-900 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-600 hover:text-white transition duration-200">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 5. Final Conversion -->
    <section class="bg-blue-600 rounded-[3rem] p-12 lg:p-20 relative overflow-hidden">
        <div class="relative z-10 flex flex-col lg:flex-row items-center gap-12 text-center lg:text-left">
            <div class="flex-1 space-y-6">
                <h2 class="text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                    Ready to grow your global trade footprint?
                </h2>
                <p class="text-blue-100 text-lg font-medium opacity-90 max-w-xl">
                    Join thousands of verified businesses already scaling their operations on MarketFlow. Simple onboarding, powerful management tools.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="/register?role=seller" class="bg-white text-blue-600 px-10 py-4 rounded-xl font-bold text-sm hover:bg-blue-50 transition shadow-xl shadow-blue-900/20">
                        Join as a Seller
                    </a>
                    <a href="#" class="text-white border border-blue-400 px-10 py-4 rounded-xl font-bold text-sm hover:bg-blue-500 transition">
                        Speak to Sales
                    </a>
                </div>
            </div>
            <div class="flex-1 hidden lg:flex justify-end">
                <svg class="w-64 h-64 text-blue-500 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
        </div>
    </section>
</div>
@endsection