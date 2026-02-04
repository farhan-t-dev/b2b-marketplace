@extends('layouts.app')

@section('title', 'Manage Products - Seller Hub')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="/seller/dashboard" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manage Catalog</h1>
        </div>
        <a href="{{ route('seller.products.create') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-blue-700 transition shadow-xl shadow-blue-100">Add New Product</a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Product</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Variants</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Inventory</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($products as $product)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-200 shadow-sm">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">{{ $product->title }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID: #{{ $product->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-xs font-bold text-slate-600 uppercase">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-slate-500">
                            {{ $product->variants->count() }}
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900">{{ $product->variants->sum('stock') }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Units Total</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border
                                @if($product->status === 'active') bg-emerald-50 text-emerald-600 border-emerald-100
                                @elseif($product->status === 'draft') bg-slate-50 text-slate-500 border-slate-100
                                @else bg-rose-50 text-rose-600 border-rose-100 @endif">
                                {{ $product->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-3">
                                @if($product->status === 'draft')
                                    <form action="{{ route('seller.products.publish', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-emerald-600 hover:bg-emerald-50 px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-emerald-100">
                                            Publish
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-blue-100">
                                    Edit
                                </a>

                                <form action="/api/seller/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Archive this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 p-2 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-6">
        {{ $products->links() }}
    </div>
</div>
@endsection