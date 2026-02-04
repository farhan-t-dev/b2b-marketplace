@extends('layouts.app')

@section('title', 'Manage Users - Admin Control')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="/admin/dashboard" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">User Management</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Review registrations, verify sellers, and manage access.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Identity</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Role & Type</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Verification</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Join Date</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50/50 transition {{ $user->trashed() ? 'opacity-60 grayscale' : '' }}">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center space-x-4">
                                <div class="h-12 w-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-lg border border-slate-200">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">{{ $user->name }}</p>
                                    <p class="text-xs font-bold text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider
                                {{ $user->isAdmin() ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-slate-50 text-slate-600 border border-slate-100' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($user->seller)
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black {{ $user->seller->status === 'active' ? 'text-emerald-600' : 'text-orange-500' }} uppercase">
                                        {{ $user->seller->shop_name }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-0.5 uppercase tracking-tighter">Status: {{ $user->seller->status }}</span>
                                </div>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Standard Account</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-slate-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-3">
                                @if($user->seller && $user->seller->status === 'pending')
                                    <form action="{{ route('admin.sellers.approve', $user->seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition shadow-lg shadow-emerald-100">
                                            Verify Shop
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                    @csrf
                                    @if($user->trashed())
                                        <button type="submit" class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-blue-100">
                                            Activate
                                        </button>
                                    @else
                                        <button type="submit" class="text-rose-600 hover:bg-rose-50 px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-rose-100" {{ $user->isAdmin() ? 'disabled opacity-30' : '' }}>
                                            Suspend
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-6">
        {{ $users->links() }}
    </div>
</div>
@endsection