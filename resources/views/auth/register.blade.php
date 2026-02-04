@extends('layouts.app')

@section('title', 'Register - MarketPlace')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-200" x-data="{ role: 'buyer' }">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
        <p class="text-gray-500">Join the B2B marketplace community.</p>
    </div>

    <form method="POST" action="/register" class="space-y-6">
        @csrf
        
        <!-- Role Toggle -->
        <div class="flex p-1 bg-gray-100 rounded-lg">
            <button type="button" @click="role = 'buyer'" class="flex-1 py-2 text-sm font-bold rounded-md transition" :class="role === 'buyer' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'">Buyer</button>
            <button type="button" @click="role = 'seller'" class="flex-1 py-2 text-sm font-bold rounded-md transition" :class="role === 'seller' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'">Seller</button>
        </div>
        <input type="hidden" name="role" :value="role">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('email') }}">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Seller Fields -->
        <template x-if="role === 'seller'">
            <div class="space-y-6">
                <div>
                    <label for="shop_name" class="block text-sm font-medium text-gray-700">Shop Name</label>
                    <input type="text" name="shop_name" id="shop_name" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('shop_name') }}">
                    @error('shop_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Shop Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                </div>
            </div>
        </template>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
            Create Account
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-gray-500">
        Already have an account? <a href="/login" class="font-bold text-blue-600 hover:text-blue-500">Log in here</a>
    </p>
</div>
@endsection
