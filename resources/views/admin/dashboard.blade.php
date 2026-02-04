@extends('layouts.app')

@section('title', 'Admin Command Center - MarketPlace')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Command <span class="text-blue-600">Center</span></h1>
            <p class="text-slate-500 mt-1 font-medium text-sm uppercase tracking-widest">Platform-wide Administration & Analytics</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">
                Live Status: Healthy
            </span>
        </div>
    </div>

    <!-- Enhanced Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Global Users</p>
                <p class="text-4xl font-black text-slate-900 mt-2">{{ $stats['total_users'] }}</p>
                <div class="mt-4 flex items-center text-xs font-bold text-emerald-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    {{ $stats['new_users_today'] }} joined today
                </div>
            </div>
            <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-blue-50 transition duration-500">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Sellers</p>
                <p class="text-4xl font-black text-blue-600 mt-2">{{ $stats['total_sellers'] }}</p>
                @if($stats['pending_sellers'] > 0)
                    <div class="mt-4 flex items-center text-xs font-bold text-orange-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ $stats['pending_sellers'] }} awaiting approval
                    </div>
                @else
                    <div class="mt-4 text-xs font-bold text-slate-400 uppercase tracking-widest italic">All verified</div>
                @endif
            </div>
            <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-indigo-50 transition duration-500">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Platform Revenue</p>
                <p class="text-4xl font-black text-emerald-600 mt-2">${{ number_format($stats['total_revenue'], 2) }}</p>
                <div class="mt-4 text-xs font-bold text-slate-400 uppercase tracking-widest italic">Gross processed</div>
            </div>
            <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-emerald-50 transition duration-500">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catalog Size</p>
                <p class="text-4xl font-black text-slate-900 mt-2">{{ $stats['total_products'] }}</p>
                <div class="mt-4 text-xs font-bold text-slate-400 uppercase tracking-widest italic">SKUs across all categories</div>
            </div>
            <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-blue-50 transition duration-500">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Activity Feed (Recent Orders) -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-100 bg-slate-50/30 flex justify-between items-center">
                <div>
                    <h2 class="font-black text-slate-900 uppercase tracking-tight">Recent Activity</h2>
                    <p class="text-xs text-slate-500 font-medium">Global order flow across the marketplace</p>
                </div>
                <button class="bg-white border border-slate-200 p-2 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </button>
            </div>
            <div class="divide-y divide-slate-100 flex-grow">
                @foreach($recentOrders as $order)
                    <div class="p-6 flex items-center justify-between hover:bg-slate-50/50 transition">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $order->buyer->name }} &rarr; {{ $order->seller->shop_name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-slate-900">${{ number_format($order->total, 2) }}</p>
                            <span class="text-[10px] font-black uppercase text-blue-500">{{ $order->status }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-6 bg-slate-50/50 border-t border-slate-100">
                <a href="#" class="block w-full text-center text-xs font-black text-slate-500 uppercase tracking-widest hover:text-blue-600 transition">Analyze All Transactions</a>
            </div>
        </div>

        <!-- Right Side: User & Seller Pulse -->
        <div class="space-y-8 flex flex-col">
            <!-- New Sellers -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="font-black text-slate-900 uppercase tracking-tight">Seller Pulse</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($recentSellers as $seller)
                        <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition">
                            <div class="flex items-center space-x-3 min-w-0">
                                <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs uppercase italic">
                                    S
                                </div>
                                <div class="truncate">
                                    <p class="text-sm font-black text-slate-900 truncate">{{ $seller->shop_name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $seller->user->name }}</p>
                                </div>
                            </div>
                            @if($seller->status === 'pending')
                                <a href="{{ route('admin.users') }}" class="bg-emerald-500 text-white p-1.5 rounded-lg hover:bg-emerald-600 transition shadow-lg shadow-emerald-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </a>
                            @else
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Management Tools -->
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 space-y-6">
                    <h3 class="font-black text-xl tracking-tight text-white uppercase italic">Management <span class="text-blue-500">Toolkit</span></h3>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between bg-slate-800 p-4 rounded-2xl hover:bg-blue-600 transition duration-300">
                            <span class="text-xs font-black uppercase tracking-widest">User Access</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="{{ route('admin.products') }}" class="flex items-center justify-between bg-slate-800 p-4 rounded-2xl hover:bg-blue-600 transition duration-300">
                            <span class="text-xs font-black uppercase tracking-widest">Catalog Audit</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-10 group-hover:scale-110 transition duration-1000">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.532 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection