@extends('layouts.app')

@section('title', 'Leonce - Smart Tips & Stories for Car Lovers')

@section('content')
<!-- Hero: Featured Post -->
@if ($featured)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-6">
    <a href="{{ route('posts.show', $featured) }}" class="block card-editorial group">
        <div class="md:flex">
            <div class="md:w-1/2 relative bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center p-16 min-h-[280px] overflow-hidden">
                @if ($featured->image)
                    <img src="{{ asset('postimage/' . $featured->image) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover absolute inset-0">
                @else
                    <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                @endif
            </div>
            <div class="md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-block bg-brand-100 text-brand-700 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $featured->category->name }}
                    </span>
                    <span class="text-xs text-gray-400">Featured</span>
                </div>
                <h2 class="font-editorial text-2xl md:text-3xl font-bold text-gray-900 mb-3 group-hover:text-brand-600 transition">
                    {{ $featured->title }}
                </h2>
                <p class="text-gray-500 mb-5 line-clamp-3">{{ Str::limit($featured->excerpt, 200) }}</p>
                <div class="flex items-center gap-3 text-sm text-gray-400 mb-5">
                    <span class="font-medium text-gray-700">{{ $featured->user->name }}</span>
                    <span>·</span>
                    <span>{{ $featured->published_at->format('M d, Y') }}</span>
                    <span>·</span>
                    <span>{{ $featured->reading_time }} min read</span>
                </div>
                <span class="inline-flex items-center text-brand-600 font-semibold text-sm group-hover:text-brand-700 transition w-fit">
                    Read Full Story
                    <svg class="ml-1 w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </div>
        </div>
    </a>
</section>
@endif

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Category Filter Pills -->
    <nav class="py-6 border-b border-gray-200 mb-8" x-data="{ active: '{{ $activeCategory ?? 'all' }}' }">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('home') }}"
               :class="active === 'all' ? 'pill-active' : 'pill-inactive'"
               @click="active = 'all'"
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-150">
                All Posts
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('home', ['category' => $category->slug]) }}"
                   :class="active === '{{ $category->slug }}' ? 'pill-active' : 'pill-inactive'"
                   @click="active = '{{ $category->slug }}'"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-150">
                    {{ $category->name }}
                    <span class="ml-1 text-xs opacity-60">({{ $category->posts_count }})</span>
                </a>
            @endforeach
        </div>
    </nav>

    <!-- Blog Grid + Sidebar -->
    <section class="pb-16">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Posts Grid -->
            <div class="flex-1">
                @if ($posts->count())
                    <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($posts as $post)
                            <article class="card-editorial flex flex-col">
                                <div class="relative bg-gradient-to-br from-brand-300 to-brand-500 h-36 flex items-center justify-center overflow-hidden">
                                    @if ($post->image)
                                        <img src="{{ asset('postimage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-12 h-12 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <span class="inline-block bg-brand-50 text-brand-600 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-3 w-fit">
                                        {{ $post->category->name }}
                                    </span>
                                    <h3 class="font-editorial text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ route('posts.show', $post) }}" class="hover:text-brand-600 transition">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-1">{{ Str::limit($post->excerpt, 100) }}</p>
                                    <div class="flex items-center text-xs text-gray-400 gap-2 mb-3">
                                        <span class="font-medium text-gray-600">{{ $post->user->name }}</span>
                                        <span>·</span>
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                        <span>·</span>
                                        <span>{{ $post->reading_time }} min read</span>
                                    </div>
                                    <a href="{{ route('posts.show', $post) }}" class="text-brand-600 hover:text-brand-700 text-sm font-semibold inline-flex items-center transition w-fit">
                                        Read More
                                        <svg class="ml-1 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $posts->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <p class="text-gray-400 text-lg">No posts found.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-72 shrink-0 space-y-6">
                <!-- Categories -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-editorial font-bold text-gray-900 mb-4 text-lg">Categories</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('home') }}" class="flex items-center justify-between text-sm py-2 px-2 rounded-lg {{ !$activeCategory ? 'text-brand-600 bg-brand-50 font-medium' : 'text-gray-600 hover:text-brand-600 hover:bg-gray-50' }} transition">
                                <span>All Posts</span>
                            </a>
                        </li>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('home', ['category' => $category->slug]) }}" class="flex items-center justify-between text-sm py-2 px-2 rounded-lg {{ $activeCategory === $category->slug ? 'text-brand-600 bg-brand-50 font-medium' : 'text-gray-600 hover:text-brand-600 hover:bg-gray-50' }} transition">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Popular Tags -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-editorial font-bold text-gray-900 mb-4 text-lg">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-stone-100 text-stone-600 text-xs px-3 py-1 rounded-full hover:bg-brand-50 hover:text-brand-600 cursor-pointer transition">#CarCare</span>
                        <span class="bg-stone-100 text-stone-600 text-xs px-3 py-1 rounded-full hover:bg-brand-50 hover:text-brand-600 cursor-pointer transition">#AI</span>
                        <span class="bg-stone-100 text-stone-600 text-xs px-3 py-1 rounded-full hover:bg-brand-50 hover:text-brand-600 cursor-pointer transition">#EcoFriendly</span>
                        <span class="bg-stone-100 text-stone-600 text-xs px-3 py-1 rounded-full hover:bg-brand-50 hover:text-brand-600 cursor-pointer transition">#Waterless</span>
                        <span class="bg-stone-100 text-stone-600 text-xs px-3 py-1 rounded-full hover:bg-brand-50 hover:text-brand-600 cursor-pointer transition">#Detailing</span>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="bg-gradient-to-br from-brand-500 to-brand-700 rounded-xl shadow-md p-5 text-white">
                    <h3 class="font-editorial font-bold mb-2 text-lg">Newsletter</h3>
                    <p class="text-brand-100 text-sm mb-4">Get new posts straight to your inbox.</p>
                    <form>
                        <input type="email" placeholder="Your email" class="w-full px-3 py-2 rounded-lg text-gray-700 text-sm mb-2 focus:ring-2 focus:ring-white/50">
                        <button type="submit" class="w-full bg-white text-brand-700 font-semibold py-2 rounded-lg text-sm hover:bg-brand-50 transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </section>
</div>
@endsection
