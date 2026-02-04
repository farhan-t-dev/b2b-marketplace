@extends('layouts.app')

@section('title', 'Seller Hub - MarketPlace')

@section('content')
<div class="space-y-10">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Seller <span class="text-blue-600">Hub</span></h1>
            <p class="text-slate-500 mt-1 font-medium">Welcome back, {{ Auth::user()->name }}. Here's what's happening with your store.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.products.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition shadow-xl shadow-blue-100 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                New Product
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-blue-200 transition group">
            <div class="h-12 w-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Inventory</p>
            <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['total_products'] }} <span class="text-xs font-bold text-slate-400 ml-1">Items</span></p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-indigo-200 transition group">
            <div class="h-12 w-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Orders</p>
            <p class="text-3xl font-black text-indigo-600 mt-1">{{ $stats['total_orders'] }}</p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-orange-200 transition group">
            <div class="h-12 w-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pending Fulfillment</p>
            <p class="text-3xl font-black text-orange-500 mt-1">{{ $stats['pending_orders'] }}</p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-200 transition group">
            <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Store Revenue</p>
            <p class="text-3xl font-black text-emerald-600 mt-1">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                <div>
                    <h2 class="font-black text-slate-900 uppercase tracking-tight">Recent Orders</h2>
                    <p class="text-xs text-slate-500 font-medium">Your latest 5 incoming orders</p>
                </div>
                <a href="{{ route('seller.orders') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:bg-blue-50 px-3 py-2 rounded-lg transition border border-blue-100">View All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Order</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Buyer</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="font-black text-slate-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    <span class="block text-[10px] font-bold text-slate-400">{{ $order->created_at->format('M d') }}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="text-sm font-bold text-slate-700">{{ $order->buyer->name }}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="text-sm font-black text-slate-900">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap text-right">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                        @if($order->status === 'pending') bg-orange-50 text-orange-600 
                                        @elseif($order->status === 'delivered') bg-emerald-50 text-emerald-600
                                        @else bg-blue-50 text-blue-600 @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Activity/Products -->
        <div class="space-y-8">
            <!-- Top Products -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="font-black text-slate-900 uppercase tracking-tight">Best Sellers</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($topProducts as $product)
                        <div class="p-6 flex items-center space-x-4 hover:bg-slate-50 transition">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-200">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-grow min-w-0">
                                <p class="font-black text-slate-900 truncate text-sm">{{ $product->title }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $product->variants_count }} Variants</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded uppercase border border-emerald-100">Active</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-6 bg-slate-50/50 border-t border-slate-100">
                    <a href="{{ route('seller.products') }}" class="block w-full text-center text-xs font-black text-slate-500 uppercase tracking-widest hover:text-blue-600 transition">Manage Catalog</a>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="bg-blue-600 rounded-3xl p-8 text-white shadow-xl shadow-blue-100 relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="font-black text-xl tracking-tight mb-2 text-white">Optimize Your Shop</h3>
                    <p class="text-blue-100 text-sm leading-relaxed mb-6">Add clear descriptions and multiple variants to increase your B2B conversion rate by up to 40%.</p>
                    <a href="#" class="inline-block bg-white text-blue-600 px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-50 transition">Read Guide</a>
                </div>
                <!-- Abstract BG Pattern -->
                <div class="absolute -right-4 -bottom-4 opacity-20 group-hover:scale-110 transition duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.536 14.95a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM6.464 14.95a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414z"></path></svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection