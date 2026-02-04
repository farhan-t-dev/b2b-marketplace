@extends('layouts.app')

@section('title', 'Browse All Products - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Browse Products</h1>
            <p class="text-slate-500 mt-1 font-medium italic text-sm">Empowering B2B commerce through verified global networks.</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <form action="{{ route('products.index') }}" method="GET" class="flex items-center space-x-3">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Sort by:</span>
                <select name="sort" onchange="this.form.submit()" class="bg-white border-slate-200 rounded-xl text-xs font-bold focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Arrivals</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        <!-- Sidebar Filters -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest border-b border-slate-100 pb-4">Categories</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('products.index', request()->only(['q', 'sort'])) }}" 
                           class="flex items-center justify-between group">
                            <span class="text-sm font-bold {{ !request('category') ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }} transition">All Categories</span>
                            @if(!request('category'))
                                <div class="h-1.5 w-1.5 rounded-full bg-blue-600"></div>
                            @endif
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products.index', array_merge(request()->only(['q', 'sort']), ['category' => $cat->slug])) }}" 
                               class="flex items-center justify-between group">
                                <span class="text-sm font-bold {{ request('category') == $cat->slug ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }} transition">{{ $cat->name }}</span>
                                @if(request('category') == $cat->slug)
                                    <div class="h-1.5 w-1.5 rounded-full bg-blue-600"></div>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Ad/Promo Placeholder -->
            <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden group shadow-xl shadow-slate-200">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-400 mb-2">Enterprise Edition</p>
                    <h4 class="text-xl font-black tracking-tight mb-4">Bulk Order Discounts Available</h4>
                    <p class="text-slate-400 text-xs leading-relaxed mb-6 font-medium">Verified businesses get access to tier-based wholesale pricing.</p>
                    <a href="#" class="text-[10px] font-black uppercase tracking-widest border border-slate-700 px-4 py-2 rounded-lg hover:bg-white hover:text-slate-900 transition">Contact Sales</a>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.536 14.95a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM6.464 14.95a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Active Filters Info -->
            @if(request('q') || request('category'))
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Active Filters:</span>
                    <div class="flex flex-wrap gap-2">
                        @if(request('q'))
                            <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-blue-100 flex items-center">
                                Search: "{{ request('q') }}"
                                <a href="{{ route('products.index', request()->only(['category', 'sort'])) }}" class="ml-2 hover:text-blue-900">&times;</a>
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="bg-slate-900 text-white px-3 py-1.5 rounded-xl text-xs font-bold flex items-center">
                                Category: {{ request('category') }}
                                <a href="{{ route('products.index', request()->only(['q', 'sort'])) }}" class="ml-2 text-slate-400 hover:text-white">&times;</a>
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($products as $product)
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-2xl hover:border-blue-100 hover:-translate-y-1 transition duration-500 group">
                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <div class="aspect-w-4 aspect-h-3 bg-slate-50 relative overflow-hidden h-64 border-b border-slate-50">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 font-black italic uppercase text-[10px] tracking-widest">Image Pending</div>
                                @endif
                                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md shadow-lg px-4 py-2 rounded-2xl text-sm font-black text-blue-600 border border-slate-100">
                                    ${{ number_format($product->variants->min('price'), 2) }}
                                </div>
                            </div>
                            <div class="p-8 space-y-4">
                                <div class="flex justify-between items-center">
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-1 rounded-md">{{ $product->category->name ?? 'Global' }}</p>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $product->seller->shop_name }}</span>
                                </div>
                                <h3 class="text-slate-900 font-black tracking-tight text-xl group-hover:text-blue-600 transition">{{ $product->title }}</h3>
                                <p class="text-slate-500 text-sm line-clamp-2 h-10 leading-relaxed font-medium">{{ $product->description }}</p>
                                
                                <div class="pt-6 flex items-center justify-between border-t border-slate-50">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Inventory</span>
                                        <span class="text-xs font-black {{ $product->variants->sum('stock') > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                            {{ $product->variants->sum('stock') > 0 ? 'READY TO SHIP' : 'OUT OF STOCK' }}
                                        </span>
                                    </div>
                                    <div class="bg-slate-900 text-white group-hover:bg-blue-600 p-3.5 rounded-2xl transition shadow-xl shadow-slate-200 group-hover:shadow-blue-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border border-dashed border-slate-200">
                        <div class="h-20 w-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">No products found</h3>
                        <p class="text-slate-500 mt-2 font-medium">Try adjusting your filters or search term.</p>
                        <a href="/products" class="inline-block mt-8 text-blue-600 font-black uppercase tracking-widest text-[10px] border-b-2 border-blue-600 pb-1">Reset Filters</a>
                    </div>
                @endforelse
            </div>

            <div class="py-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection