@extends('layouts.app')

@section('title', 'Admin Dashboard - MarketPlace')

@section('content')
<div class="space-y-8">
    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Platform Overview</h1>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Users</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Sellers</p>
            <p class="text-3xl font-black text-blue-600 mt-2">{{ $stats['total_sellers'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Products</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Orders</p>
            <p class="text-3xl font-black text-indigo-600 mt-2">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Revenue</p>
            <p class="text-3xl font-black text-emerald-600 mt-2">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="font-black text-slate-900 uppercase tracking-tight">Recent User Registrations</h2>
                <a href="/admin/users" class="text-xs font-bold text-blue-600 uppercase tracking-widest hover:underline">Manage All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($recentUsers as $user)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded uppercase">{{ $user->role }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Sellers -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="font-black text-slate-900 uppercase tracking-tight">New Seller Shops</h2>
                <a href="/admin/users" class="text-xs font-bold text-blue-600 uppercase tracking-widest hover:underline">Manage All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($recentSellers as $seller)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs italic">
                                Shop
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $seller->shop_name }}</p>
                                <p class="text-xs text-slate-500">By {{ $seller->user->name }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded uppercase">{{ $seller->status }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
