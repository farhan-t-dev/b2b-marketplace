@extends('layouts.app')

@section('title', 'Moderate Products - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4">
        <a href="/admin/dashboard" class="p-2 rounded-full hover:bg-slate-200 transition">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Product Moderation</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Seller</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Price Range</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @foreach($products as $product)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <span class="text-sm font-bold text-slate-900 truncate w-48">{{ $product->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $product->seller->shop_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                            ${{ $product->variants->min('price') }} - ${{ $product->variants->max('price') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded uppercase border border-emerald-100">{{ $product->status }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <form action="/admin/products/{{ $product->id }}/status" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-[10px] font-bold border-slate-200 rounded-lg py-1 focus:ring-blue-500" onchange="this.form.submit()">
                                    <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="archived" {{ $product->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </form>
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
