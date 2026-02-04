@extends('layouts.app')

@section('title', 'Product Categories - MarketPlace')

@section('content')
<div class="space-y-12">
    <div class="text-center max-w-2xl mx-auto space-y-4">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Industry <span class="text-blue-600">Categories</span></h1>
        <p class="text-slate-500 font-medium leading-relaxed">Browse our specialized B2B categories to find the exact supplies and materials your business needs to scale.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group relative bg-white p-10 rounded-[3rem] border border-slate-200 shadow-sm hover:shadow-2xl hover:border-blue-100 transition-all duration-500 overflow-hidden">
                <div class="relative z-10 space-y-4">
                    <div class="h-16 w-16 rounded-3xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition duration-500 shadow-lg shadow-blue-50">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight group-hover:text-blue-600 transition">{{ $category->name }}</h3>
                        <p class="text-slate-400 text-xs font-black uppercase tracking-widest mt-1">{{ $category->products_count }} Active Products</p>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium line-clamp-2">
                        Discover top-tier {{ strtolower($category->name) }} solutions from verified manufacturers and distributors worldwide.
                    </p>
                    <div class="pt-4 flex items-center text-blue-600 text-[10px] font-black uppercase tracking-widest group-hover:translate-x-2 transition duration-300">
                        Explore Category <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                <!-- Abstract Decorative Pattern -->
                <div class="absolute -right-8 -bottom-8 opacity-[0.03] group-hover:opacity-[0.08] transition duration-500 text-slate-900">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.536 14.95a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM6.464 14.95a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414z"></path></svg>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Become a Seller Promo -->
    <div class="bg-slate-900 rounded-[4rem] p-12 lg:p-20 text-white relative overflow-hidden group shadow-2xl">
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="max-w-xl text-center lg:text-left space-y-6">
                <h2 class="text-4xl font-black tracking-tight leading-tight">Don't see your category? <span class="text-blue-500 italic">Create it.</span></h2>
                <p class="text-slate-400 font-medium text-lg leading-relaxed">Join our rapidly growing network of B2B sellers and define new marketplaces. We provide the tools, you provide the expertise.</p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="/register?role=seller" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition shadow-xl shadow-blue-900/50">Start Selling Now</a>
                    <a href="#" class="border border-slate-700 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white hover:text-slate-900 transition">View Seller Guide</a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <div class="h-64 w-64 rounded-[3rem] border-8 border-blue-600/20 flex items-center justify-center transform rotate-12 group-hover:rotate-0 transition duration-1000">
                    <svg class="w-32 h-32 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
