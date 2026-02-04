<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'B2B Marketplace')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-black text-blue-600 tracking-tight">Market<span class="text-slate-900">Place</span></a>
                        </div>
                        <div class="hidden sm:flex sm:space-x-4">
                            <a href="/" class="text-slate-600 hover:text-blue-600 px-3 py-2 text-sm font-semibold transition">
                                Explore
                            </a>
                            <a href="#" class="text-slate-600 hover:text-blue-600 px-3 py-2 text-sm font-semibold transition">
                                Categories
                            </a>
                        </div>
                    </div>

                    <!-- Search Bar placeholder for better UI -->
                    <div class="hidden md:flex flex-1 items-center justify-center px-8">
                        <div class="w-full max-w-lg relative">
                            <form action="/" method="GET">
                                <input type="text" name="q" placeholder="Search for products, sellers..." 
                                       class="w-full bg-slate-100 border-transparent rounded-xl py-2 pl-10 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                       value="{{ request('q') }}">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                        @auth
                            <a href="/cart" class="text-slate-600 hover:text-blue-600 p-2 rounded-lg transition relative group">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h12l1 12H4L5 9z"></path></svg>
                                @if(Auth::user()->cart && Auth::user()->cart->items->count() > 0)
                                    <span class="absolute top-0 right-0 -mt-1 -mr-1 px-1.5 py-0.5 text-[10px] font-black bg-blue-600 text-white rounded-full group-hover:scale-110 transition">
                                        {{ Auth::user()->cart->items->count() }}
                                    </span>
                                @endif
                            </a>
                            
                            @if(Auth::user()->isSeller())
                                <a href="/seller/dashboard" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-800 transition">Seller Hub</a>
                            @endif

                            @if(Auth::user()->isAdmin())
                                <a href="/admin/dashboard" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition">Admin</a>
                            @endif

                            <div class="ml-3 relative" x-data="{ userMenu: false }">
                                <button @click="userMenu = !userMenu" class="flex text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border border-slate-200 p-1 hover:bg-slate-50 transition">
                                    <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-black">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="ml-2 mr-1 self-center font-bold text-slate-700">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                    <svg class="h-4 w-4 text-slate-400 self-center" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                                <div x-show="userMenu" @click.away="userMenu = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-xl py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                    <div class="px-4 py-3 border-b border-slate-100">
                                        <p class="text-sm font-medium text-slate-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="/orders" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">My Orders</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Account Settings</a>
                                    <hr class="my-1 border-slate-100">
                                    <form method="POST" action="/logout">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50 transition">Sign out</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="/login" class="text-slate-600 hover:text-blue-600 text-sm font-bold transition">Login</a>
                                <a href="/register" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">Get Started</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0 text-emerald-500">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0 text-rose-500">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-bold text-rose-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-1 md:col-span-1 space-y-6">
                        <a href="/" class="text-2xl font-black text-white tracking-tight">Market<span class="text-blue-500">Place</span></a>
                        <p class="text-sm leading-relaxed">
                            The most trusted B2B multi-vendor platform for global commerce. Built with performance and security at its core.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-1.012-2.175-1.644-3.594-1.644-2.717 0-4.92 2.203-4.92 4.917 0 .39.044.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.735-.671 1.589-.671 2.502 0 1.707.869 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/></svg></a>
                            <a href="#" class="hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm4.441 16.892c-2.102.144-6.784.144-8.883 0-2.276-.156-2.541-1.27-2.558-4.892.017-3.629.285-4.736 2.558-4.892 2.099-.144 6.782-.144 8.883 0 2.277.156 2.541 1.27 2.559 4.892-.018 3.629-.285 4.736-2.559 4.892zM10 9.658l4.295 2.342L10 14.342V9.658z"/></svg></a>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <h3 class="text-white font-bold uppercase tracking-widest text-xs">Marketplace</h3>
                        <ul class="space-y-4 text-sm">
                            <li><a href="/" class="hover:text-white transition">Browse Products</a></li>
                            <li><a href="#" class="hover:text-white transition">Top Sellers</a></li>
                            <li><a href="#" class="hover:text-white transition">New Arrivals</a></li>
                            <li><a href="#" class="hover:text-white transition">Categories</a></li>
                        </ul>
                    </div>
                    <div class="space-y-6">
                        <h3 class="text-white font-bold uppercase tracking-widest text-xs">For Businesses</h3>
                        <ul class="space-y-4 text-sm">
                            <li><a href="/register?role=seller" class="hover:text-white transition">Sell on MarketPlace</a></li>
                            <li><a href="#" class="hover:text-white transition">Seller Guidelines</a></li>
                            <li><a href="#" class="hover:text-white transition">Shipping Policy</a></li>
                            <li><a href="#" class="hover:text-white transition">Commissions</a></li>
                        </ul>
                    </div>
                    <div class="space-y-6">
                        <h3 class="text-white font-bold uppercase tracking-widest text-xs">Support</h3>
                        <ul class="space-y-4 text-sm">
                            <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                            <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                            <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-xs text-slate-500 font-medium">
                        &copy; {{ date('Y') }} MarketPlace B2B MVP. Designed for portfolio showcase.
                    </p>
                    <div class="flex space-x-6 text-xs font-bold text-slate-500 uppercase tracking-widest">
                        <span>Made with ❤️ using Laravel 11</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>