<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 bg-brand-600 rounded-full inline-block"></span>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">Leonce</span>
                </a>
                <div class="hidden sm:flex sm:items-center sm:ms-10 sm:space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-brand-600' : '' }}">Home</a>
                    <a href="#" class="text-gray-600 hover:text-brand-600 text-sm font-medium transition">About</a>
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 text-sm font-medium transition">Blog</a>
                    <a href="#" class="text-gray-600 hover:text-brand-600 text-sm font-medium transition">Contact</a>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden sm:flex sm:items-center sm:space-x-3">
                        <form method="GET" action="{{ route('home') }}" class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                                class="w-48 lg:w-64 pl-9 pr-3 py-1.5 rounded-full border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </form>
                        <a href="{{ route('register') }}" class="bg-brand-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-brand-700 transition">
                            Newsletter
                        </a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-600 text-sm font-medium hover:text-brand-600 flex items-center gap-1 transition">
                                {{ Auth::user()->name }}
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Admin Panel</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                <hr class="my-1 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex sm:items-center sm:space-x-3">
                        <form method="GET" action="{{ route('home') }}" class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                                class="w-48 lg:w-64 pl-9 pr-3 py-1.5 rounded-full border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </form>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-600 text-sm font-medium transition">Log in</a>
                        <a href="{{ route('register') }}" class="bg-brand-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-brand-700 transition">
                            Register
                        </a>
                    </div>
                @endauth

                <div class="sm:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-600 hover:text-brand-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="sm:hidden bg-white border-t border-gray-100">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-brand-600 rounded-md text-base font-medium">Home</a>
            <a href="#" class="block px-3 py-2 text-gray-600 hover:text-brand-600 rounded-md text-base font-medium">About</a>
            <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-600 hover:text-brand-600 rounded-md text-base font-medium">Blog</a>
            <a href="#" class="block px-3 py-2 text-gray-600 hover:text-brand-600 rounded-md text-base font-medium">Contact</a>
        </div>
        <div class="border-t border-gray-100 px-4 py-3">
            <form method="GET" action="{{ route('home') }}" class="relative mb-3">
                <input type="text" name="search" placeholder="Search articles..."
                    class="w-full pl-9 pr-3 py-2 rounded-full border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
            @auth
                <div class="text-gray-900 text-sm font-semibold mb-2">{{ Auth::user()->name }}</div>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-600 hover:text-brand-600 text-sm">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-gray-600 hover:text-brand-600 text-sm">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-gray-600 hover:text-brand-600 text-sm">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-600 hover:text-brand-600 text-sm">Log in</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-white bg-brand-600 rounded-md text-sm text-center mt-1 font-semibold">Register</a>
            @endauth
        </div>
    </div>
</nav>
