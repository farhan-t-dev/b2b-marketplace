@extends('layouts.app')

@section('title', 'Login - MarketPlace')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Welcome Back</h1>
        <p class="text-gray-500">Login to manage your business.</p>
    </div>

    <form method="POST" action="/login" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('email') }}">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>
            <div class="text-sm">
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Forgot password?</a>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
            Sign In
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-gray-500">
        Don't have an account? <a href="/register" class="font-bold text-blue-600 hover:text-blue-500">Register here</a>
    </p>
</div>
@endsection
