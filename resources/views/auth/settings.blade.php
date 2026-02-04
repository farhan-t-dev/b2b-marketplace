@extends('layouts.app')

@section('title', 'Account Settings - MarketPlace')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{ tab: 'profile' }">
    <div class="flex items-center space-x-4">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Account <span class="text-blue-600">Settings</span></h1>
    </div>

    <!-- Tabs -->
    <div class="flex space-x-1 bg-slate-200 p-1 rounded-2xl w-fit">
        <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition">Profile</button>
        <button @click="tab = 'security'" :class="tab === 'security' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition">Security</button>
        @if($user->isSeller())
            <button @click="tab = 'store'" :class="tab === 'store' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition">Store Details</button>
        @endif
    </div>

    <!-- Profile Section -->
    <div x-show="tab === 'profile'" x-transition class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
        <div class="border-b border-slate-100 pb-6">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Personal Information</h2>
            <p class="text-slate-500 text-sm font-medium mt-1">Update your basic account details.</p>
        </div>

        <form action="{{ route('settings.profile') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full h-12 bg-slate-50 border-slate-200 rounded-xl px-4 font-bold focus:bg-white focus:ring-4 focus:ring-blue-50 transition">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full h-12 bg-slate-50 border-slate-200 rounded-xl px-4 font-bold focus:bg-white focus:ring-4 focus:ring-blue-50 transition">
                </div>
            </div>
            
            <input type="hidden" name="role" value="{{ $user->role }}">
            <div class="flex justify-end">
                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-800 transition shadow-xl shadow-slate-200">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Security Section -->
    <div x-show="tab === 'security'" x-transition class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
        <div class="border-b border-slate-100 pb-6">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Security</h2>
            <p class="text-slate-500 text-sm font-medium mt-1">Change your password to keep your account secure.</p>
        </div>

        <form action="{{ route('settings.password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full h-12 bg-slate-50 border-slate-200 rounded-xl px-4 font-bold focus:bg-white focus:ring-4 focus:ring-blue-50 transition">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">New Password</label>
                        <input type="password" name="password" class="w-full h-12 bg-slate-50 border-slate-200 rounded-xl px-4 font-bold focus:bg-white focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="w-full h-12 bg-slate-50 border-slate-200 rounded-xl px-4 font-bold focus:bg-white focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-blue-700 transition shadow-xl shadow-blue-100">Update Password</button>
            </div>
        </form>
    </div>

    <!-- Store Section (Sellers only) -->
    @if($user->isSeller())
        <div x-show="tab === 'store'" x-transition class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-8">
            <div class="border-b border-slate-100 pb-6 text-center md:text-left flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Business Profile</h2>
                    <p class="text-slate-500 text-sm font-medium mt-1">This information is visible to potential buyers.</p>
                </div>
                <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100 self-center">Status: {{ $user->seller->status }}</span>
            </div>

            <form action="{{ route('settings.profile') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="hidden" name="role" value="{{ $user->role }}">

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Registered Shop Name</label>
                        <input type="text" name="shop_name" value="{{ old('shop_name', $user->seller->shop_name) }}" class="w-full h-12 bg-slate-50 border-slate-200 rounded-xl px-4 font-bold focus:bg-white focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Shop Description</label>
                        <textarea name="description" rows="5" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-4 font-medium focus:bg-white focus:ring-4 focus:ring-blue-50 transition">{{ old('description', $user->seller->description) }}</textarea>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-800 transition shadow-xl shadow-slate-200">Update Store</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
