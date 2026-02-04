@extends('layouts.app')

@section('title', 'Manage Orders - Seller Hub')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="/seller/dashboard" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Incoming Orders</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Manage fulfillment and track buyer shipments.</p>
            </div>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-[3rem] p-20 text-center border border-dashed border-slate-200">
            <div class="h-20 w-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 tracking-tight">No incoming orders yet</h3>
            <p class="text-slate-500 mt-2 font-medium">As soon as buyers start purchasing, they will appear here.</p>
        </div>
    @else
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Order Details</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Buyer Identity</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Value</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Fulfillment</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <p class="text-sm font-black text-slate-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mt-0.5">{{ $order->created_at->format('M d, Y • H:i') }}</p>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <p class="text-sm font-bold text-slate-700">{{ $order->buyer->name }}</p>
                                <p class="text-[10px] font-medium text-slate-400 lowercase">{{ $order->buyer->email }}</p>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="text-sm font-black text-slate-900">${{ number_format($order->total, 2) }}</span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border
                                    @if($order->status === 'delivered') bg-emerald-50 text-emerald-600 border-emerald-100
                                    @elseif($order->status === 'pending') bg-orange-50 text-orange-600 border-orange-100
                                    @elseif($order->status === 'cancelled') bg-rose-50 text-rose-600 border-rose-100
                                    @else bg-blue-50 text-blue-600 border-blue-100 @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right">
                                <form action="{{ route('seller.orders.status', $order->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="text-[10px] font-black uppercase tracking-widest border-slate-200 rounded-xl py-2 px-3 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition bg-slate-50">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="bg-slate-900 text-white p-2 rounded-xl hover:bg-blue-600 transition shadow-lg shadow-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="py-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection