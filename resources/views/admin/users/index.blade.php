@extends('layouts.app')

@section('title', 'Manage Users - MarketPlace')

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4">
        <a href="/admin/dashboard" class="p-2 rounded-full hover:bg-slate-200 transition">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manage Users</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Joined</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Shop Status</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                            {{ $user->name }} <span class="block text-xs font-normal text-slate-500">{{ $user->email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded uppercase">{{ $user->role }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->seller)
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded uppercase">{{ $user->seller->status }}</span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="#" class="text-blue-600 hover:text-blue-900">View</a>
                                <button class="text-rose-600 hover:text-rose-900">Suspend</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $users->links() }}
    </div>
</div>
@endsection
