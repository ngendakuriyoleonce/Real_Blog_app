<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="text-sm text-gray-600">Browse and comment on articles from the <a href="{{ route('home') }}" class="text-brand-600 hover:underline">homepage</a>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-500">All Posts</h4>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Post::where('status', 'published')->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-500">Categories</h4>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Category::count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-500">Users</h4>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
